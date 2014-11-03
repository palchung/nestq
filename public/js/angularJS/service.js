angular.module('messengerService', [])

    .factory('Messenger', function ($http) {
        return {
            save: function (messageData) {
                return $http({
                    method: 'POST',
                    url: 'http://nestq.local:8000/messenger/save_message',
                    headers: {'Content-Type': 'application/x-www-form-urlencoded'},
                    data: $.param(messageData)
                });
            },
            // destroy a comment
            /*destroy: function(id) {
             return $http.delete('/apsssi/messager/' + id);
             }*/

            loadConversation: function(conversationData){
                return $http({
                    method: 'POST',
                    url: 'http://nestq.local:8000/messenger/load_conversation',
                    headers: {'Content-Type': 'application/x-www-form-urlencoded'},
                    data: $.param(conversationData)
                });
            },

            loadMessage: function(messageData){
                return $http({
                    method: 'POST',
                    url: 'http://nestq.local:8000/messenger/load_message',
                    headers: {'Content-Type': 'application/x-www-form-urlencoded'},
                    data: $.param(messageData)
                });
            }



        };




        });


        angular.module('activepushService', [])

            .factory('Activepush', function ($http) {
                return {
                    save: function (pushData) {
                        return $http({
                            method: 'POST',
                            url: 'http://localhost:8888/nestq/public/count_active_push',
                            headers: {'Content-Type': 'application/x-www-form-urlencoded'},
                            data: $.param(pushData)
                        });
                    },
                    // destroy a comment
                    /*destroy: function(id) {
                     return $http.delete('/apsssi/messager/' + id);
                     }*/
                };

            });
