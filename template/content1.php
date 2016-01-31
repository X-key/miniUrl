<div  id="minimaizer">
    <form id="minimaizerform" role="form" action="index.php" method="POST">
        <div>Enter link would you like to short</div>
        <div class="form-group">
            <input class="form-control" id="longlink" type="text" placeholder="Enter long URL" name="longurl">
        </div>
        <div class="radio" >
            <div>Select Life Time for link</div>
            <label >
                <input type="radio" name="lifetimeoptions" id="optionsRadios2" value="0"  checked>
                No limit time
            </label>
            <label >
                <input type="radio" name="lifetimeoptions" id="optionsRadios2" value="30"  >
                30m
            </label>
            <label>
                <input type="radio" name="lifetimeoptions" id="optionsRadios2" value="60"  >
                1h
            </label>
            <label>
                <input type="radio" name="lifetimeoptions" id="optionsRadios2" value="120" >
                2h
            </label>
            <label>
                <input type="radio" name="lifetimeoptions" id="optionsRadios2" value="300" >
                5h
            </label>
        </div>
        <div class="radio" >
            <div>If you want own short link pls select</div>
            <label >
                <input type="radio" name="ownlink" id="optionsRadios3" value="1"  onClick="document.getElementById('ownshortlink').disabled=false;" value="Enable">
                Input own short link
            </label>
        </div>
        <div>Enter your Own short link</div>
        <div class="form-group">
            <input  class="form-control" id="ownshortlink"  type="text" placeholder="input your own short URL" name="ownshorturl" disabled >
        </div>
        <div class="form-group">
            <input  class="btn btn-default" type="submit"  name="save"  value="Short">
        </div>
    </form>


    <form id="minimaizerform" role="form" action="index.php" method="POST">
        <div class="form-group">
            <input class="form-control" id="shortlink" type="text" placeholder="Enter short URL" name="shortlink">
        </div>
        <div class="form-group">
            <input  class="btn btn-default" type="submit"  name="enter"  value="Shorten URL">
        </div>
    </form>
</div>
<div id="result">
    <div class="form-group">
        <input class="form-control" type="text" id="customshortlink" placeholder="{{customshortlink}}">
    </div>
</div>

