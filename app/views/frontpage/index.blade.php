


<div class='frontpage-image-wrapper'>
    <div class="slogan">
        <h2 class="color-secondary">Nestq</h2>
        <br/>
        <br/>
        <p>
            就在今天，
            輕鬆地搜尋 <span class="color-secondary std-bold">家</span> <br/>
            <br/>
            {{ HTML::link('#menu-search', '開始搜尋',['class'=>'button_lg']) }}
        </p>
    </div>
    <img class="frontpage-image" src="{{ asset("image/frontpage-image.jpg")}}">
</div>



<div class="two-col index-register">
    <div class='left'>

        <a href="{{ url('account/agentregister')}}" >
            <div class="std-thumbnail std-border center">
                <i class="icon-crosshairs"></i>
                <div class="std-caption">
                    <br/>
                    <h1>物業代理</h1><br/>
                    現在就注冊，立刻發佈樓盤資訊！

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
                    <h1>業主 / 用戶</h1><br/>
                    注冊後便可用盡 Nestq 的功能。 揾樓，賣樓，既方便又快捷。

                </div>
            </div>
        </a>


    </div>
</div>



<div id="cbp-so-scroller" class="cbp-so-scroller">
    <!-- <section class="cbp-so-section">
        <article class="cbp-so-side cbp-so-side-left">
            <h2 class="color-secondary">Nestq</h2>
            <p>
                就在今天，
                輕鬆地搜尋 <span class="color-secondary std-bold">家</span> <br/>
                <br/>
                {{ HTML::link('#menu-search', '開始搜尋',['class'=>'button_lg']) }}
            </p>
        </article>
        <figure class="cbp-so-side cbp-so-side-right">
            <img src="image/4.jpg" alt="img01">
        </figure>
    </section> -->
    <section class="cbp-so-section">
        <figure class="cbp-so-side cbp-so-side-left">
            <img src="image/1.jpg" alt="img01">
        </figure>
        <article class="cbp-so-side cbp-so-side-right">
            <ul class="list-inline"><li><i class="icon-paper-plane-o"></i></li><li> <h2> 輕鬆 </h2></li></ul>
            <p>
                設計簡約的 Nestq。找物業代理，放盤，搵樓變得非常容易。
            </p>
        </article>
    </section>
    <section class="cbp-so-section">
        <article class="cbp-so-side cbp-so-side-left">
            <ul class="list-inline"><li><i class="icon-share-alt"></i></li><li> <h2> 精準 </h2></li></ul>
            <p>
                獨家的樓盤推播功能。
                按用戶喜好，將物業資訊主動推送給用戶，實現<br/><span class="color-secondary std-bold">精準行銷</span>。
            </p>
        </article>
        <figure class="cbp-so-side cbp-so-side-right">
            <img src="image/2.jpg" alt="img01">
        </figure>
    </section>
    <section class="cbp-so-section">
        <figure class="cbp-so-side cbp-so-side-left">
            <img src="image/3.jpg" alt="img01">
        </figure>
        <article class="cbp-so-side cbp-so-side-right">
            <ul class="list-inline"><li><i class="icon-envelope-o"></i></li><li> <h2> 即時通 </h2></li></ul>
            <p>
                及時，快速的即時通訊功能。幫助您與客戶緊密聯絡，儘快<span class="color-secondary std-bold">促成交易</span>。
            </p>
        </article>
    </section>
    <section class="cbp-so-section">
        <a href="{{ url('account/userregister')}}" >
            <article class="cbp-so-side cbp-so-side-left">
                <ul class="list-inline"><li><i class="icon-coffee"></i></li><li> <h2> 業主 / 用家 </h2></li></ul>
                <p>
                    我們重視您的個人資料。找代理，自售物業？沒有問題！
                    簡單步驟即可完成。
                </p>
            </article>
        </a>
        <figure class="cbp-so-side cbp-so-side-right">
            <img src="image/5.jpg" alt="img01">
        </figure>

    </section>
    <section class="cbp-so-section">
        <figure class="cbp-so-side cbp-so-side-left">
            <img src="image/6.jpg" alt="img01">
        </figure>
        <a href="{{ url('account/agentregister')}}" >
            <article class="cbp-so-side cbp-so-side-right">
                <ul class="list-inline"><li><i class="icon-crosshairs"></i></li><li> <h2> 物業代理 </h2></li></ul>
                <p>
                    Nestq 明白成功交易才是目標，多種功能幫助您主動吸引客戶，
                </p>
            </article>
        </a>
    </section>
</div>
</div>








<script>
    new cbpScroller( document.getElementById( 'cbp-so-scroller' ) );
</script>




