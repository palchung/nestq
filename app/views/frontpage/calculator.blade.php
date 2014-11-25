<div class="searchbox-wrapper" ng-controller="calculatorCtrl">

    <div class="searchbox">樓按計算機</div>
    <br/>
    <br/>
    <br/>


    <div class="std-border white-bg std-padding">

        <table class="std-table">
            <tr>
                <td>物業價值(萬)</td>
                <td>
                    <input type='text' class="form-control" ng-model="price" placeholder='萬'/>
                </td>
            </tr>
            <tr>
                <td>貸款比率(%):</td>
                <td>
                    <input type='text' class="form-control" ng-model="loan" placeholder='%'/>
                </td>
            </tr>
            <tr>
                <td>按揭還款期(年):</td>
                <td>
                    <input type='text' class="form-control" ng-model="year" placeholder='年'/>
                </td>
            </tr>
            <tr>
                <td>按揭年息(%):</td>
                <td>
                    <input type='text' class="form-control" ng-model="interest" placeholder='%'/>
                </td>
            </tr>
            <!-- <tr>
                <td>SSD 額外印花稅</td>
                <td>
                    <input type="checkbox" ng-model="ssd" id="ssd" class="std-checkbox">
                    <label for="ssd" class="checkbox-label"></label>
                </td>
            </tr>
            <tr>
                <td>BSD 買家印花稅</td>
                <td>
                    <input type="checkbox" ng-model="bsd" id="bsd" class="std-checkbox">
                    <label for="bsd" class="checkbox-label"></label>
                </td>
            </tr>
            <tr>
                <td>DSD 雙倍印花稅</td>
                <td>
                    <input type="checkbox" ng-model="dsd" id="dsd" class="std-checkbox">
                    <label for="dsd" class="checkbox-label"></label>
                </td>
            </tr> -->


        </table>


        <hr/>

        <span class="std-bold color-secondary">按揭計算結果</span>
        <br/>

        <table class="std-table">
            <tr>
                <td>貸款額:</td>
                <td>$<[cost.total_loan(price, loan)]> 萬</td>
            </tr>
            <tr>
                <td><span class="std-bold color-primary">首期:</span></td>
                <td><span class="std-bold color-primary">$<[cost.inital_cost(price, loan)]> 萬</span></td>
            </tr>
            <tr>
                <td><span class="std-bold color-primary">每月還款:</span></td>
                <td><span class="std-bold color-primary">$<[cost.monthly_paid(price, interest, year, loan)]> 元</span> </td>
            </tr>
            <tr>
                <td>還款期數:</td>
                <td><[cost.return_period(year)]> 期</td>
            </tr>
        </table>
        <hr/>

        <span class="std-bold color-secondary">其他買樓費用開支</span>
        <br/>
        <table class="std-table">
            <tr>
                <td>印花稅:</td>
                <td>$<[cost.tax(price)]> 元</td>
            </tr>
            <tr>
                <td>律師買賣合約:</td>
                <td>$<[cost.lawer_fee(price)]> 元</td>
            </tr>
            <tr>
                <td>屋契/按揭契:</td>
                <td>$<[cost.contact_fee(price)]> 元</td>
            </tr>
            <tr>
                <td>代理佣金:</td>
                <td>$<[cost.agent_fee(price)]> 元</td>
            </tr>
            <!-- <tr>
                <td>SSD 額外印花稅:</td>
                <td></td>
            </tr>
            <tr>
                <td>BSD 買家印花稅:</td>
                <td></td>
            </tr>
            <tr>
                <td>DSD 雙倍印花稅:</td>
                <td></td>
            </tr> -->

        </table>


        <hr/>
        <!-- <table class="std-table">
            <tr>
                <td><span class="std-bold color-primary">總開支:</span></td>
                <td><[grand_total]></td>
            </tr>
        </table> -->


    </div>


</div>