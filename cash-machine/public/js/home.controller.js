(function () {
  'use strict';
  angular.module('cashMachine')
  .controller('HomeController', HomeController);

  function HomeController($http, toastr) {
    var vm = this;

    vm.calculateDeliver = calculateDeliver;
    vm.wait = false;


    function calculateDeliver() {
      if (vm.amount === undefined || vm.amount === '') {
        toastr.error('Insert amount');
        return false;
      }
      vm.wait = true;
      $http.get('/api/v1/withdraw/' + vm.amount)
      .then(
        function success(response) {
          vm.wait = false;
          vm.error = vm.notes = null;
          if (response.data.notes) {
            vm.notes = response.data.notes;
          } else {
            vm.error = 'Unknown error';
          }
        },
        function error(response) {
          vm.wait = false;
          if (response.data.message) {
            vm.error = response.data.message;
          } else if (response.data.error) {
            vm.error = response.data.error;
          }
        }
        );
    }
  }
})();
