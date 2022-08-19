var nestq = angular.module('nestq', ['ui.bootstrap', 'messengerService', 'activepushService'],
    function ($interpolateProvider) {
        $interpolateProvider.startSymbol('<[');
        $interpolateProvider.endSymbol(']>');
    });




nestq.controller('ActivePushCtrl', ['$scope', '$interval', '$http', 'Activepush',
    function ($scope, $interval, $http, Activepush) {

        $scope.showpush = false;
        $scope.ajax = {};
        var activepush = new EventSource("http://" + window.location.host + "/activepush");
        activepush.onopen = function (event) {
           console.log("open: ", event.data);
        };
        activepush.onmessage = function (event) {

            $scope.$apply(function () {
                $scope.pushproperty = JSON.parse(event.data);
                $interval(function () {
                    $scope.showpush = true;
                }, 7000);  //1000 = 1s
                $scope.showpush = false;


                $scope.ajax.propertyId = $scope.pushproperty.id;
                Activepush.save($scope.ajax)
                .success(function (data) {
                    console.log("countActivePush: ", data.response);
                })
                .error(function (data) {
                    console.log(data);
                });
            });
            console.log("pushProperty: ", $scope.pushproperty);
        };
        activepush.onerror = function (event) {
           console.log("error: ", event.data);
        };
    }]);


nestq.controller('NotificationCtrl', ['$scope',
    function ($scope) {

        var notification = new EventSource("http://" + window.location.host + "/notification");

        notification.onmessage = function (event) {
            $scope.$apply(function () {
                $scope.notice = JSON.parse(event.data)

            });

        };

    }]);


nestq.controller('messengerCtrl', ['$scope', '$http', 'Messenger',
    function ($scope, $http, Messenger) {

        $scope.title = '';
        $scope.conversationData = {};
        $scope.messageData = {};
        $scope.submitmessageData = {};
        $scope.message = {};
        $scope.properties = [];
        $scope.message.toDisplay = [];
        $scope.hideMessage = true;


        var currPanel = 0;
        var $slider = $('#full-slider');
        var $sliderPanels = $slider.children('.slide-panel');

        var connection = new EventSource("http://" + window.location.host + "/angularJS");

        connection.onmessage = function (event) {
            $scope.$apply(function () {
                $scope.properties = JSON.parse(event.data);
                //connection.close();
                //console.log("contacts: ", event.data);
            });
        };


        $scope.switchToConversation = function (property_id) {

            $scope.conversationData.propertyId = property_id;

            Messenger.loadConversation($scope.conversationData)
            .success(function (data) {

                $scope.title = '聯絡人';
                currPanel++;
                    // check if the new panel value is too big
                    if (currPanel >= $sliderPanels.length)
                        currPanel = 0;
                    slidePanel(currPanel, 'left');

                    $scope.pushConversation = data.response;

                    //console.log("loadConversation: ", data.response);
                })
            .error(function (data) {
                console.log(data);
            });


        };

        $scope.switchToMessage = function (conversation_id, property_id) {

            $scope.messageData.conversationId = conversation_id;
            $scope.message.propertyId = property_id;
            $scope.message.conversationId = conversation_id;
            $scope.message.toDisplay.length = 0;


            Messenger.loadMessage($scope.messageData)
            .success(function (data) {
                $scope.title = '訊息';
                currPanel++;
                if (currPanel >= $sliderPanels.length)
                    currPanel = 0;
                slidePanel(currPanel, 'left');

                $scope.pushMessage = data.response;
                $scope.hideMessage = false;

                var lastCell = $scope.pushMessage.length - 1;


                $scope.message.lastid = $scope.pushMessage[lastCell].message_id;


                var listener = new EventSource("http://" + window.location.host + "/messengerMessage/" + conversation_id);

                listener.onmessage = function (event) {
                    $scope.$apply(function () {

                        $scope.message.databaseMessage = JSON.parse(event.data);
                            //$scope.message.totalMessage = $scope.pushMessage ;

                            if ($scope.message.databaseMessage.message_id != $scope.message.lastid && $scope.message.databaseMessage != 'no_new_message') {
                                $scope.message.toDisplay.push($scope.message.databaseMessage);
                                $scope.message.lastid = $scope.message.databaseMessage.message_id;
                            }

                            //console.log("Listener ", $scope.message.databaseMessage);

                        });
                };


                    //console.log("loadMessage: ", data.response);
                })
.error(function (data) {
    console.log(data);
});


};

$scope.switchBack = function () {
    currPanel--;
    if (currPanel == 0) {
        $scope.title = '物業';
    }
    if (currPanel == 1) {
        $scope.title = '聯絡人';
    }
    if (currPanel == 2) {
        $scope.title = '訊息';
    }
            // check if the new panel value is too small
            if (currPanel < 0)
                currPanel = $sliderPanels.length - 1;
            slidePanel(currPanel, 'right');

            $scope.message.toDisplay.length = 0;

        };

        function slidePanel(newPanel, direction) {
            // define the offset of the slider obj, vis a vis the document
            var offsetLeft = $slider.offset().left;
            // offset required to hide the content off to the left / right
            var hideLeft = -1 * (offsetLeft + $slider.width());
            var hideRight = $(window).width() - offsetLeft;
            // change the current / next positions based on the direction of the animation
            if (direction == 'left') {
                currPos = hideLeft;
                nextPos = hideRight;
            }
            else {
                currPos = hideRight;
                nextPos = hideLeft;
            }
            // slide out the current panel, then remove the active class
            $slider.children('.slide-panel.active').animate({
                left: currPos
            }, 500, function () {
                $(this).removeClass('active');
            });
            // slide in the next panel after adding the active class
            $($sliderPanels[newPanel]).css('left', nextPos).addClass('active').animate({
                left: 0
            }, 400);
        }

        $scope.disabled = false;


        $scope.submitMessage = function (conversation_id, property_id) {

            $scope.disabled = true;
            $scope.hideMessage = false;
            $scope.submitmessageData.conversationId = conversation_id;
            $scope.submitmessageData.propertyId = property_id;
            $scope.submitmessageData.message = $scope.message.new;


            // save the comment. pass in comment data from the form
            // use the function we created in our service
            Messenger.save($scope.submitmessageData)
            .success(function (data) {

                $scope.message.new = '';
                    //$scope.message.savedData = JSON.parse(data.response)
                    $scope.message.toDisplay.push(data.response);


                    console.log("sendMesage: ", data.response);
                    $scope.disabled = false;
                })
            .error(function (data) {
                console.log(data);
            });


        };


    }]);


nestq.controller('searchboxCtrl', ['$scope', '$http',
    function ($scope, $http) {

        $scope.isCollapsed = true;

    }]);




nestq.controller('calculatorCtrl', ['$scope',
    function ($scope) {

        $scope.price = 200;
        $scope.loan = 70;
        $scope.year = 25;
        $scope.interest = 2.5;

        $scope.cost = [];

        $scope.cost.inital_cost = function inital_cost(price, loan) {
            var cal = price*(1-loan/100);

            var ans = parseInt(cal) || 0;

            return ans.toFixed(1) ;
        }


        $scope.cost.return_period = function return_period(year) {
            var cal = year*12;

            var ans = parseInt(cal) || 0;

            return ans ;
        }

        $scope.cost.total_loan = function total_loan(price, loan) {
            var cal = price* loan / 100;

            var ans = parseInt(cal) || 0;

            return ans.toFixed(0) ;
        }

        $scope.cost.total_interest = function total_interest(price, interest, year, loan) {

            var cal = NPV(price, loan, interest, year);

            var ans = parseInt(cal) || 0;


            return ans.toFixed(0) ;
        }


        $scope.cost.agent_fee = function agent_fee(price) {

            var cal = (price * 1 / 100) * 10000 ;

            var ans = parseInt(cal) || 0;

            return ans.toFixed(0) ;
        }

        $scope.cost.contact_fee = function contact_fee(price) {

            var ans = 0;
            if (price <= 10 ){
                ans = 1800 ;
            }else if(price >10 && price <=15 ){
                ans = 2450 ;
            }else if(price >15 && price <=20 ){
                ans = 3100 ;
            }else if(price >20 && price <=25 ){
                ans = 3750 ;
            }else if(price >25 && price <=50 ){
                ans = 3750 + (price - 25) * 100 ;
            }else if(price >50 && price <=100 ){
                ans = 6250 + (price - 50) * 75 ;
            }else if(price >100 && price <=500 ){
                ans = 10000 + (price - 100) * 50 ;
            }else if(price>500){
                ans = 30000 + (price - 500) * 25 ;
            }

            return ans.toFixed(0) ;
        }


        $scope.cost.lawer_fee = function lawer_fee(price) {
            var ans = 0;
            if (price <= 200 ){
                ans = 1500 ;
            }else if(price >200 && price <=300 ){
                ans = 2000 ;
            }else if(price>300){
                ans = 2500 ;
            }
            return ans.toFixed(0) ;
        }


        $scope.cost.tax = function tax(price) {

            var ans = 0;

            if (price <= 200){
                ans = 100 / 10000;
            }else if(price>200 && price <=235.1760){
                ans = 100 + (price - 200) * 10 / 100;
            }else if(price>235.1760 && price <=300){
                ans = price * 1.5 / 100;
            }else if(price>300 && price <=329.0320){
                ans = 45000 + (price - 300) * 10 / 100;
            }else if(price>329.0320 && price <=400){
                ans = price * 2.25 / 100;
            }else if(price>400 && price <=442.8570){
                ans = 90000 + (price - 400) * 10 / 100;
            }else if(price>442.8570 && price <=600){
                ans = price * 3 / 100;
            }else if(price>600 && price <=672.0000){
                ans = 180000 + (price - 600) * 10 / 100;
            }else if(price>672.0000 && price <=2000){
                ans = price * 3.75 / 100;
            }else if(price>2000 && price <=2173.9130){
                ans = 750000 + (price - 2000) * 10 / 100;
            }else if(price>2173.9130){
                ans = price * 4.25 / 100;
            }

            var answer = ans * 10000 ;

            return answer.toFixed(0) ;
        }




        $scope.cost.monthly_paid = function monthly_paid(price, interest, year, loan) {
            var ir = interest / 100 / 12 ;
            var np = year * 12 ;
            var pv = price * loan ;
            var fv = 0 ;

            var cal = PMT(ir, np, pv, fv, 0) * 100;

            var ans = parseInt(cal) || 0;

            return ans.toFixed(0) ;
        }


        function NPV(price, loan, interest, year) {

          var inital = price * loan ;
          var period = year ;
          var rate = interest / 100 ;
          var value = 0;

               // Loop on all values
               for (var j = 0; j <= period; j++) {

                value += inital / Math.pow(1 + rate, j);

            }
              // Return net present value
              return value;
          }


          function PMT(ir, np, pv, fv, type) {
            /*
             * ir   - interest rate per month
             * np   - number of periods (months)
             * pv   - present value
             * fv   - future value
             * type - when the payments are due:
             *        0: end of the period, e.g. end of month (default)
             *        1: beginning of period
             */
             var pmt, pvif;

             fv || (fv = 0);
             type || (type = 0);

             if (ir === 0)
                return (pv + fv)/np;

            pvif = Math.pow(1 + ir, np);
            pmt = ir * pv * (pvif + fv) / (pvif - 1);

            if (type === 1)
                pmt /= (1 + ir);

            return pmt;
        }






    }]);




























nestq.filter('unique', function () {
    return function (collection, keyname) {
        var output = [],
        keys = [];

        angular.forEach(collection, function (item) {
            var key = item[keyname];
            if (keys.indexOf(key) === -1) {
                keys.push(key);
                output.push(item);
            }
        });

        return output;
    };
});