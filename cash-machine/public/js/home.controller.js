(function () {
  'use strict';
  angular.module('cashMachine')
  .controller('HomeController', HomeController);

  function HomeController($http, toastr) {
    var vm = this;

    vm.calculateDelivery = calculateDelivery;
    vm.wait = false;


    function calculateDelivery() {
      if (vm.amount === undefined || vm.amount === '') {
        toastr.error('Insert amount');
        return false;
      }
      vm.wait = true;
      vm.notes = null;
      $http.get('/api/v1/withdraw/' + vm.amount)
      .then(
        function success(response) {
          vm.wait = false;
          if (response.data.notes) {
            vm.notes = response.data.notes;
            toastr.success('Take your money');
          } else {
            toastr.error('Unknown error');
          }
        },
        function error(response) {
          vm.wait = false;
          if (response.data.message) {
            var error = response.data.message;
          } else if (response.data.error) {
            var error = response.data.error;
          }
          toastr.error(error);
        }
        );
    }
  }
})();
