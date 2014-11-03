        <div class="namecard-grid">
        <div class="std-thumbnail">

                <div class="media">
                  <a class="pull-left" href="#">
                      @if($account->profile_pic)
                      {{ HTML::image('profilepic/' . $account->profile_pic, $account->firstname . $account->lastname, array('class' => '')) }}
                      @else
                      <i class="icon-user-5x"></i>
                      @endif
                  </a>
                  <div class="media-body">
                    <h4 class="media-heading">{{$account->firstname}} {{$account->lastname}}</h4>
                    @if($account->identity == 1)
                    <small> - 物業代理</small>
                    @elseif($account->identity == 0)
                    <small> - 業主 / 用家</small>
                    @endif
                </div>
            </div>

            <div class="caption">

                <hr/>

                已發佈物業數量: <span class="pull-right std-bold">{{$nosProperty}}</span> <br/>
                <hr/>
                Email:
                <span class="pull-right std-bold">{{$account->email}} </span> <br/>
                電話: <span class="pull-right std-bold">{{$account->tel}}</span> <br/>


                @if ($account->identity == 1)
                手機: <span class="pull-right std-bold">{{$account->cell_tel}}</span></li> <br/>
                <hr/>
                評級: <span class="pull-right std-bold">{{$account->rating}}</span> <br/>
                牌照: <span class="pull-right std-bold">{{$account->license}}</span></li> <br/>
                公司: <span class="pull-right std-bold">{{$account->company}}</span></li> <br/>
                <hr/>
                介紹: <br/>
                <div class="std-bold wrap-text">{{$account->description}}</div>

                @endif

            </div>
        </div>
    </div>
