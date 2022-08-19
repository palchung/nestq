



<div class="row">
        <div class="col-md-12">
                <h1>Chat</h1>
                <table class="table table-striped">
                        <tbody>
                                @{{#each message in model}}
                                <tr>
                                        <td @{{bind-attr class="message.user_id_class"}}>
                                                @{{message.user_name}}
                                        </td>
                                        <td>
                                                @{{message.message}}
                                        </td>
                                </tr>
                                @{{/each}}
                        </tbody>
                </table>
        </div>
</div>
<div class="row">
        <div class="col-md-12">
                <div class="input-group">
                        @{{input type="text" value=command class="form-control"}}
                        <span class="input-group-btn">
                                <button class="btn btn-default"  @{{action "send"}}>
                                        Send
                                </button>
                        </span>
                </div>
        </div>
</div>



























<!--


<script type="text/x-handlebars">
            @{{outlet}}
        </script>


<script type="text/x-handlebars" data-template-name="chats" >
          
                <div class="row">
            <div class="col-md-12">
                <h1>Laravel 4 Chat</h1>
                <table class="table table-striped">
                <tbody>
                    @{{#each message in model}}
                        <tr>
                            <td @{{bind-attr class="message.user_id_class"}}>
                                @{{message.user_name}}
                            </td>
                            <td>
                                @{{message.message}}
                            </td>
                        </tr>
                    @{{/each}}
                    </tbody>
                </table>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="input-group">
                    @{{input
                        type="text"
                        value=command
                        class="form-control"
                    }}
                    <span class="input-group-btn">
                        <button
                            class="btn btn-default"
                            @{{action "send"}}
                        >
                            Send
                        </button>
                    </span>
                </div>
            </div>
        </div>
           
        </script>
        



                <script type="text/javascript" src="{{ asset("js/ember/handlebars.js") }}"></script>
                <script type="text/javascript" src="{{ asset("js/ember/ember.js") }}"></script>
                <script type="text/javascript" src="{{ asset("js/ember/emberdata.js") }}"></script>
                <script type="text/javascript" src="{{ asset("js/chat/application.js") }}"></script>
                <script type="text/javascript" src="{{ asset("js/chat/router.js") }}"></script>
                <script type="text/javascript" src="{{ asset("js/chat/chat.js") }}"></script>
                <script type="text/javascript" src="{{ asset("js/chat/model/model.js") }}"></script>
                <script type="text/javascript" src="{{ asset("js/chat/controller/controller.js") }}"></script>
                <script type="text/javascript" src="{{ asset("js/chat/view/view.js") }}"></script>
                

-->