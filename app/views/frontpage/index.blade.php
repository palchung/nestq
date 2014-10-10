


<div class="full-width">

    <ul class="slogan">
        <li><h1 class="std-bold">Nestq - </h1></li>
        <li><h1 class="std-bold">Find property in Simple way</h1></li>
        <li>{{ HTML::link('#menu-search', 'Search Now',['class'=>'button_normal']) }}</li>

    </ul>
    <img class="frontpage-image" src="{{ asset("image/frontpage-image.jpg")}}">

</div>



<div class="two-col">
    <div class='left'>

        <a href="{{ url('account/agentregister')}}" >
            <div class="std-thumbnail std-border center">
                <i class="icon-crosshairs"></i>
                <div class="std-caption">
                    <br/>
                    <h1>Agent</h1><br/>
                    Register now to connect to your client !

                </div>
            </div>
        </a>

    </div>
    <div class='right'>
        <a href="{{ url('account/userregister')}}" >
            <div class="std-thumbnail std-border center">
                <i class="icon-coffee"></i>
                <div class="std-caption">
                    <br/>
                    <h1>User</h1><br/>
                    Register to sell your property !

                </div>
            </div>
        </a>


    </div>
</div>














<hr/>


<div class="full-width align-center">
    <h1>Nestq Services</h1>
</div>
<br/>


<div class="three-col">
    <div class="left">
        <a href="{{ url('inquiry/posting')}}" >
            <div class="std-thumbnail std-border center">
                <i class="icon-paper-plane-o"></i>
                <div class="std-caption">
                    <br/>
                    <span class="title">Find agent without pressure</span>
                    <p>

                        <b>Find the top gun for your property</b><br/>
                        turn on / off agent seeking function in action

                    </p>

                </div>
            </div>
        </a>
    </div>
    <div class="middle">

        <a href="{{ url('inquiry/activepush')}}" >
            <div class="std-thumbnail std-border center">
                <i class="icon-share-alt"></i>
                <div class="std-caption">
                    <br/>
                    <span class="title">Active Push Service</span>
                    <p>
                        <b>your post search target actively</b><br/>
                        learn how Active Push increase contact point.
                    </p>

                </div>
            </div>
        </a>

    </div>
    <div class="right">


        <a href="{{ url('inquiry/messenger')}}" >
            <div class="std-thumbnail std-border center">
                <i class="icon-envelope-o"></i>
                <div class="std-caption">
                    <br/>
                    <span class="title">Messenger service</span>
                    <p>
                        <b>Contact in the air</b><br/>
                        messenger make conversation in time
                    </p>

                </div>
            </div>
        </a>


    </div>
</div>


<!--
<div class="full-width">
    <h1>Nestq Customers</h1>
</div> -->
<br/>


<div class='three-col align-center'>

    <div class='left'>

        <a href="{{ url('inquiry/buyer')}}" >
            <div class="std-thumbnail std-border center">
                <i class="icon-search"></i>
                <div class="std-caption">
                    <br/>
                    <span class="title">Buyer</span>
                    <p>
                        <b>Newest Massive property Information</b><br/>
                        Search property become a easy click
                    </p>

                </div>
            </div>
        </a>
    </div>
    <div class='middle'>

        <a href="{{ url('inquiry/agent')}}" >
            <div class="std-thumbnail std-border center">
                <i class="icon-crosshairs"></i>
                <div class="std-caption">
                    <br/>
                    <span class="title">Agent</span>
                    <p>
                        <b>Deal is King</b><br/>
                        Nestq increase your deal making chance
                    </p>

                </div>
            </div>
        </a>



        <!-- {{ HTML::link('account/agentregister', 'Register',['class'=>'button_sm']) }} -->

    </div>
    <div class='right'>

        <a href="{{ url('inquiry/user')}}" >
            <div class="std-thumbnail std-border center">
                <i class="icon-coffee"></i>
                <div class="std-caption">
                    <br/>
                    <span class="title">Owner</span>
                    <p>
                        <b>nestq lock your personal info up</b><br/>
                        Find a agent ? sell property yourself ? no problem !
                    </p>

                </div>
            </div>
        </a>


        <!--{{ HTML::link('account/userregister', 'Register',['class'=>'button_sm']) }} -->

    </div>

</div>


