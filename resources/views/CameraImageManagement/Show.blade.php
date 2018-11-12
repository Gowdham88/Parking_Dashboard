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
   name it private properties, forbidden places, parking place, and parking places with electric chargers -> all using different colours
   <div>
      <div style="padding: 10px;">
         Pick Color: <select name="type" id="type">
            <option value="private">Private properties</option>
            <option value="forbidden">Forbidden area</option>
            <option value="parking">Parking area</option>
            <option value="road">Road/Street</option>
            <option value="parking_with_electric_charges">Parking area with electric charges</option>
         </select>&nbsp;&nbsp;&nbsp;&nbsp;<input type="color" class="form-control" name="color" id="color"> &nbsp;&nbsp;&nbsp;&nbsp; <button id="clear">Clear Map</button> &nbsp;&nbsp;&nbsp;&nbsp; <button id="Save" onclick="saveData()">Save Points</button>
      </div>
      <div id="app">
         <div id="polygons-list">
            @foreach($drawables as $key=>$drawable)
               <div style="padding: 5px;">
                  Polygon{{ $key+1 }} <button onclick="deletePolygon({{$key}})">Delete</button>
               </div>
            @endforeach
         </div>
         <canvas id="canvas" height="{{$height}}" width="{{$width}}" style="background-image: url('{{ $camera['cameraImageUrl'] }}');background-size: cover"></canvas>
      </div>
   </div>
</body>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
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
    var type = document.querySelector('#type');
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
            polygons.push({
                type: type.value,
                color: color.value,
                points: points
            });
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
       col = hexToRgb("{{$drawable['color']}}");
       rgbacolor = 'rgba('+col.r+','+col.g+', '+col.b+', 0.4)';
       c.fillStyle=rgbacolor;
       c.strokeStyle="{{$drawable['color']}}";
       @foreach($drawable['points'] as $point)
          @if ($loop->first)
             c.beginPath();
             points.push([{{$point[0]}},{{$point[1]}}]);
             c.lineTo({{$point[0]}},{{$point[1]}});
             c.stroke();
             c.fillRect({{$point[0]}},{{$point[1]}},3,3);
             @continue
          @endif
          @if ($loop->last)
             c.lineTo({{$point[0]}},{{$point[1]}});
             points.push([{{$point[0]}},{{$point[1]}}]);
             polygons.push({
                 points: points,
                 color: "{{$drawable['color']}}",
                 type: "{{$drawable['type']}}"
             });
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
        axios.put("{{ action('CameraImageManagementController@updatePoints', $camera['cameraID']) }}", {
            polygons: polygons,
            _token: "{{ csrf_token() }}",
            _method: "put"
        }).then(function(response) {
            alert("Data updated successfully!");
        }).catch(function(error) {
            alert('There was an error. Try again later!');
        });
    }

    function updatePolygonList() {
        $("#polygons-list").html("");
        for (i=0;i<polygons.length;i++) {
            var el = "<div style=\"padding: 5px;\">\n" +
                "Polygon "+(i+1)+" <button onclick=\"deletePolygon("+i+")\">Delete</button>\n" +
                "</div>";
            $("#polygons-list").append(el);
        }
    }

    function deletePolygon(index) {
        let pgs = [];
        for (i=0;i<polygons.length;i++) {
            if (index != i) {
                pgs.push(polygons[i]);
            }
        }
        c.clearRect(0,0,canvas.offsetWidth,canvas.offsetHeight);
        polygons = pgs;
        drawPolygonsFromBeginning();
        updatePolygonList();
    }

   function drawPolygonsFromBeginning() {
        for (i=0;i<polygons.length;i++) {
            let pts = polygons[i].points;
            var  lp = 0;
            col = hexToRgb(polygons[i].color);
            rgbacolor = 'rgba('+col.r+','+col.g+', '+col.b+', 0.4)';
            c.fillStyle=rgbacolor;
            c.strokeStyle=polygons[i].color;
            for (j=0;j<pts.length;j++) {
                let x = pts[j][0];
                let y = pts[j][1];
                if (lp == 0) {
                    c.beginPath();
                    c.moveTo(x,y);
                    c.fillRect(x,y,3,3);
                    lp++;
                    continue;
                }
                if (j == pts.length-1) {
                    c.lineTo(x,y);
                    c.stroke();
                    c.fill();
                    c.closePath();
                    continue;
                }
                c.lineTo(x,y);
                c.stroke();
            }
        }
   }
</script>
</html>