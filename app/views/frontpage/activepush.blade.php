



<!-- Active Push -->
@if(!Auth::check() || Auth::user()->identity != 1)

<div ng-controller="ActivePushCtrl" class='activepush' ng-show="showpush" ng-if="pushproperty">
	<div class="media">
<!-- 		<a class="pull-left" href="/property/property-detail/<[pushproperty.id]>">
            <i ng-if="!pushproperty.photoFile" class="icon-home-5x"></i>
            <img ng-if="pushproperty.photoFile" class="media-object" src='/upload/<[pushproperty.photoPath]>/thumbnail/<[pushproperty.photoFile]>' alt="property">
        </a> -->
        <div class="media-body">
         <a class="pull-left full-width" href="/property/property-detail/<[pushproperty.id]>">
            <span class="media-heading sub-tilte"><[pushproperty.address]></span> - 實用: <[pushproperty.actualsize]> 呎

            <div class="two-col">
                <div class="left">

                    售: <[pushproperty.price]> 萬<br/>
                    租: <[pushproperty.rentprice]> 千<br/>


                </div>
                <div class="right">
                   地區: <[pushproperty.region]><br/>
                   類別: <[pushproperty.category]>

               </div>
           </div>

       </a>
   </div>

</div>
</div>

@endif