



<!-- Active Push -->
@if(!Auth::check() || Auth::user()->identity != 1)

<a class="" href="/property/property-detail/<[pushproperty.id]>">
    <div ng-controller="ActivePushCtrl" class='activepush' ng-show="showpush">
        <div class="two-col-panel">
            <div class="left-panel">
                <div class="center">
                    <i ng-if="pushproperty.photoFile == 'no_photo'" class="icon-home-4x"></i>
                    <img ng-if="pushproperty.photoPath" class="media-object" src='/upload/<[pushproperty.photoPath]>/thumbnail/<[pushproperty.photoFile]>' alt="property">

                </div>

            </div>
            <div class="right-panel">
                <span class="std-bold"><[pushproperty.address]></span>
                <br/>
                - 實: <span class="color-secondary"><[pushproperty.actualsize]> 呎</span> |

                售: <span class="color-secondary"><[pushproperty.price]> 萬</span> |
                租: <span class="color-secondary"><[pushproperty.rentprice]> 千</span><br/>

                地區: <span class="color-secondary"><[pushproperty.region]></span> |
                類別: <span class="color-secondary"><[pushproperty.category]></span>

            </div>
        </div>
    </div>
</a>

@endif