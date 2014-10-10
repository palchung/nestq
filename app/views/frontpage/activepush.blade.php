



<!-- Active Push -->
@if(!Auth::check() || Auth::user()->identity != 1)

<div ng-controller="ActivePushCtrl" class='activepush' ng-show="showpush">
	<div class="media">
		<a class="pull-left" href="http://localhost/nestq/public/property/property-detail/<[pushproperty.id]>">
			<img class="media-object" src='http://localhost:8888/nestq/public/upload/<[pushproperty.photoPath]>/thumbnail/<[pushproperty.photoFile]>' alt="property">
		</a>
		<div class="media-body">
			<a class="pull-left full-width" href="http://localhost:8888/nestq/public/property/property-detail/<[pushproperty.id]>">
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