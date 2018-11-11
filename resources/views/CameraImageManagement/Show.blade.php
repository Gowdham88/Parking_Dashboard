<html>
<head>
   <title>Mask/Unmask</title>
   <style>
      * {
         padding: 0;
         margin: 0;
      }
      
      .top {
         padding: 10px;
         text-align: left;
      }
   </style>
</head>
<body>
   <div class="top">
      <h1 class="page-header"><a href="{{ action('CameraImageManagementController@index') }}">Back</a> | Mask/Unmask Camera</h1>
   </div>
   <hr />
   <br>
   <div>
      <div style="padding: 10px;">
         Pick Color: <select name="type" id="type">
            <option value="public">Public Place</option>
            <option value="parking">Parking</option>
            <option value="playground">Playground</option>
         </select>&nbsp;&nbsp;&nbsp;&nbsp;<input type="color" class="form-control" name="color" id="color"> &nbsp;&nbsp;&nbsp;&nbsp; <button id="clear">Clear Map</button> &nbsp;&nbsp;&nbsp;&nbsp; <button id="Save">Save Points</button>
      </div>
      <div id="app">
         <canvas id="canvas" height="{{$height}}" width="{{$width}}" style="background-image: url('{{ $camera['cameraImageUrl'] }}');background-size: cover"></canvas>
      </div>
   </div>
</body>
<script src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.18.0/axios.js"></script>
<script>
    function hexToRgb(hex) {
        var result = /^#?([a-f\d]{2})([a-f\d]{2})([a-f\d]{2})$/i.exec(hex);
        return result ? {
            r: parseInt(result[1], 16),
            g: parseInt(result[2], 16),
            b: parseInt(result[3], 16)
        } : null;
    }

    var canvas = document.querySelector("canvas");
    var c= canvas.getContext("2d");
    var clickCount = 0;
    var color= document.querySelector("#color");
    col = hexToRgb(color.value);
    rgbacolor = 'rgba('+col.r+','+col.g+', '+col.b+', 0.4)';
    c.fillStyle=rgbacolor;
    c.strokeStyle=color.value;
    color.addEventListener("change",()=>{
        col = hexToRgb(color.value);
        rgbacolor = 'rgba('+col.r+','+col.g+', '+col.b+', 0.4)';
        c.fillStyle=rgbacolor;
        c.strokeStyle=color.value;
    });
    var x,y;
    var error=5;
    var firstX,firstY;
    var i=0;
    var polygons=[];
    var points=[];

    document.querySelector("#clear").addEventListener("click",()=>{
        c.clearRect(0,0,canvas.offsetWidth,canvas.offsetHeight);
        polygons = [];
        points = [];
    });


    canvas.addEventListener("click",(e)=>{
        x=e.clientX-canvas.offsetLeft;
        y=e.clientY-canvas.offsetTop+window.scrollY;
        clickCount++;
        if( (clickCount>3) && (x>=firstX-error && x<=firstX+error) && (y>=firstY-error && x<=firstX+error)){
            c.lineTo(firstX,firstY);
            points.push([firstX,firstY]);
            polygons.push(points);
            points = [];
            c.stroke();
            c.fill();
            c.closePath();
            clickCount=0;
            i++;
        }
        else{
            if(clickCount==1){
                firstX=x;
                firstY=y;
                points.push([firstX, firstY]);
                c.beginPath();
                c.moveTo(x,y);
                c.fillRect(x,y,3,3);
            }
            else{
                points.push([x,y]);
                c.lineTo(x,y);
                c.stroke();
            }
        }
    });

   @foreach($drawables as $drawable)
       c.fillStyle='{{ $drawable['colors'][1] }}';
       c.strokeStyle='{{ $drawable['colors'][0] }}';
       @foreach($drawable['points'] as $point)
          @if ($loop->first)
             points.push([{{$point[0]}},{{$point[1]}}]);
             c.lineTo({{$point[0]}},{{$point[1]}});
             c.stroke();
             c.fillRect({{$point[0]}},{{$point[1]}},3,3);
             @continue
          @endif
          @if ($loop->last)
             c.lineTo({{$point[0]}},{{$point[1]}});
             points.push([{{$point[0]}},{{$point[1]}}]);
             polygons.push(points);
             points = [];
             c.stroke();
             c.fill();
             c.closePath();
             clickCount=0;
             i++;
             @continue
          @endif
             points.push([{{$point[0]}},{{$point[1]}}]);
             c.lineTo({{$point[0]}},{{$point[1]}});
             c.stroke();
       @endforeach
   @endforeach

    col = hexToRgb('#000000');
    rgbacolor = 'rgba('+col.r+','+col.g+', '+col.b+', 0.4)';
    c.fillStyle=rgbacolor;
    c.strokeStyle='#000000';

    function saveData() {
        axios.post();
        //Save those points to PHP thing...
    }

   function drawPolygonsFromBeginning() {
        //Get the available polygons...
       //And start drawing them...
   }
</script>
</html>