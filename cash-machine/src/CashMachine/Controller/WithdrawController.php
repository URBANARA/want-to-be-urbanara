<?php

namespace CashMachine\Controller;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use CashMachine\Bootstrap;
use CashMachine\Withdraw\NoteUnavailableException;
use InvalidArgumentException;

class WithdrawController
{
    public function __invoke(Request $request, Response $response) {

      $value = $request->getAttribute('value');
      $di = Bootstrap::getServiceContainer();
      $config = $di->get('WithdrawConfig');
      $withdrawService = $di->get('WithdrawService');

      try {
          if ($value === null) {
            throw new InvalidArgumentException('Value can\'t be empty');

          }
          $results = $withdrawService->calculateDeliver($value, $config->availableNotes);
          $response->withJson([
            'notes' => $results
            ]);
      } catch (NoteUnavailableException $e) {
          $response->withJson(
              [
                  'error' => $e->getMessage(),
                  'unvailableNote' => $e->getUnavailableNote()
              ],
              500
          );
      } catch (InvalidArgumentException $e) {
          $response->withJson(
              [
                  'error' => $e->getMessage()
              ],
              500
          );
      }
      return $response;
}
}
