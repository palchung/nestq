

<div id="full-slider-wrapper" ng-controller="messengerCtrl">

	<div class="messenger">即時通 / <small class="messenger-title"><[title]></small> </div>

	@if (Auth::check())
	@if(Auth::user()->identity == 0 || (Auth::user()->identity == 1 && Service::checkServicePayment(Config::get('nestq.MESSENGER_ID') == 'paid')))


	<div id="full-slider">

		<div class="slide-panel active" >
			<a class="messenger-content" ng-repeat="property in properties | unique:'property_id'">

				<div class="messenger-block" ng-click="switchToConversation(property.property_id)">

                    <div class="messenger-two-col">
                      <div class="left">
                         <img src="http://localhost:8888/nestq/public/upload/<[property.property_photo]>/thumbnail/<[property.thumbnail]>" alt="<[property.property_name]>">
                     </div>
                     <div class="right">
                       <[property.property_name]><br/>
                       <[property.property_region]> / <[property.property_category]><br/>
                       <[property.property_price]>
                   </div>
               </div>

           </div>
       </a>

   </div>


   <div class="slide-panel">


      <a class="messenger-backward" ng-click="switchBack()">
        <div class="backward">
         返回
     </div>
 </a>



 <a class="messenger-content" ng-repeat="conversation in pushConversation | filter:{property_id:conversation.property_id} | unique: 'conversation_id, property_id' ">

    <div class="messenger-block" ng-click="switchToMessage(conversation.conversation_id, conversation.property_id)">
     <div class="messenger-two-col">
      <div class="left">
       <img src="http://localhost:8888/nestq/public/profilepic/<[conversation.account_profile_pic]>" alt="<[conversation.property_name]>">
   </div>
   <div class="right">
       <[conversation.account_firstname]> <[conversation.account_lastname]>
       <small class="light-color pull-right"><[conversation.message_created_at]></small>
   </div>
</div>
</div>
</a>

</div>




<div class="slide-panel">

    <a class="messenger-backward" ng-click="switchBack()">
        <div class="backward">
         返回
     </div>
 </a>
 <div ng-repeat="message in pushMessage | filter:{conversation_id:message.conversation_id}">
    <div class="messenger-block">
     <div class="messenger-two-col">
      <div class="left">
       <img src="http://localhost:8888/nestq/public/profilepic/<[message.account_profile_pic]>" alt="<[message.account_firstname]> <[message.account_lastname]>">
   </div>
   <div class="right">
       <b><[message.account_firstname]> <[message.account_lastname]></b>
       <small class="light-color pull-right"><[message.message_created_at]></small>
       <br/>
       <[message.message]>

   </div>
</div>
</div>
</div>















<div class="messenger-block" ng-show="hideMessage" ng-hide="hideMessage" ng-repeat="newMessage in message.toDisplay track by $index" >
    <div class="messenger-two-col">
     <div class="left">
      <img src="http://localhost:8888/nestq/public/profilepic/<[newMessage.account_profile_pic]>" alt="profile pic">
  </div>
  <div class="right">
      <b><[newMessage.account_firstname]> <[newMessage.account_lastname]></b>
      <small class="light-color pull-right"> <[newMessage.message_created_at]> </small>
      <br/>
      <[newMessage.message]>

  </div>
</div>
</div>


<div class="messenger-input-block">
    <div class="messenger-two-col">
     <div class="left">
      <img src="http://localhost:8888/nestq/public/profilepic/{{Auth::user()->profile_pic}}" alt="profile pic">
  </div>
  <div class="right">
  <span class="std-bold">{{Auth::user()->firstname}} {{Auth::user()->lastname}}</span>
      <small class="light-color pull-right"> <!-- now --> </small>
      <br/>
      <[message.new]>
      <form novalidate class="messenger-input" ng-submit="submitMessage(message.conversationId, message.propertyId)">
       <div class="input-group input-group-sm" >
        <span class="input-group-addon"><i class="icon-pencil"></i></span>
        <input ng-disabled="disabled" ng-model="message.new" type="textarea" class="form-control" placeholder="write sth">

    </div>
</form>
</div>
</div>

</div>























</div>

</div>



@elseif(Auth::user()->identity == 1 && Service::checkServicePayment(Config::get('nestq.MESSENGER_ID') != 'paid'))

<!-- AD for agent -->

<div class="messenger-ad">

   即時通幫助您與客戶緊密聯繫<br/>
   <br/>
   <a href="{{ url('payment/pricepage')}}" >
    <div class="std-thumbnail std-border">
     <i class="icon-purchase-center-black"></i>
     <div class="std-caption">
      <br/>
      <h1>講買中心</h1><br/>
      了解我們的服務計劃
  </div>
</div>
</a>

</div>


@endif

@else

<!-- AD for non-member -->

<div class="messenger-ad">
   登入後使用即時通<br/>
   還沒有賬號 ?<br/>
   來注冊吧, 免費的 ! :)<br/>

   <div class="two-col">
    <div class='left'>

     <a href="{{ url('account/agentregister')}}" >
      <div class="std-thumbnail std-border">
       <i class="icon-crosshairs"></i>
       <div class="std-caption">
        <br/>
        <h1>物業代理</h1><br/>
        <h1>注冊</h1><br/>


    </div>
</div>
</a>

</div>
<div class='right'>
 <a href="{{ url('account/userregister')}}" >
  <div class="std-thumbnail std-border">
   <i class="icon-coffee"></i>
   <div class="std-caption">
    <br/>
    <h1>業主 / 用家</h1><br/>
    <h1>注冊</h1><br/>

</div>
</div>
</a>


</div>
</div>


</div>




@endif




</div>
</div>