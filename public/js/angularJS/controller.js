var nestq = angular.module('nestq', ['ui.bootstrap', 'messengerService', 'activepushService'],
    function ($interpolateProvider) {
        $interpolateProvider.startSymbol('<[');
        $interpolateProvider.endSymbol(']>');
    });


nestq.controller('ActivePushCtrl', ['$scope', '$interval', '$http', 'Activepush',
    function ($scope, $interval, $http, Activepush) {

        $scope.showpush = false;
        $scope.ajax = {};
        var activepush = new EventSource("http://localhost:8888/nestq/public/activepush");
        //activepush.onopen = function (event) {
        //    console.log("open: ", event.data);
        //};
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
            console.log("pushProperty: ", $scope.pushproperty.id);
        };
        //activepush.onerror = function (event) {
        //    console.log("error: ", event.data);
        //};
    }]);


nestq.controller('NotificationCtrl', ['$scope',
    function ($scope) {
        var notification = new EventSource("http://localhost:8888/nestq/public/notification");
//        notification.onopen = function(event) {
//            console.log("open: ", event.data);
//        };
        notification.onmessage = function (event) {
            $scope.$apply(function () {
                $scope.notice = JSON.parse(event.data)
            });
//            console.log("Notification: ", event.data);
        };
//        notification.onerror = function(event) {
//            console.log("error: ", event.data);
//        };
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

        var connection = new EventSource("http://localhost:8888/nestq/public/angularJS");

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


                    var listener = new EventSource("http://localhost:8888/nestq/public/messengerMessage/" + conversation_id);

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