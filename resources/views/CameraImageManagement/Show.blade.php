<html>
<head>
   <title>Mask/Unmask</title>
   <style>
      *, h1, h2, h3, h4, h5, div {
         padding: 0;
         margin: 0;
      }
      
      .top {
         padding: 10px;
         text-align: left;
      }
      
      .title-bar {
         background: #999;
         color: #FFF;
         padding: 5px;
      }

      table tr td {
         vertical-align: top;
      }
   </style>
   <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
</head>
<body>
   @include('includes.header')
   <div class="top">
      <h1><a href="{{ action('CameraImageManagementController@index') }}">Back</a> | Mask/Unmask Camera</h1>
   </div>
   <div>
      <div style="padding: 10px;">
         Pick Color: <select name="type" id="type">
            <option value="private">Private properties</option>
            <option value="forbidden">Forbidden area</option>
            <option value="parking">Parking area</option>
            <option value="road">Road/Street</option>
            <option value="parking_with_electric_charges">Parking area with electric charges</option>
            <option value="side_path">Side Path</option>
         </select> <button id="clear">Clear Map</button> <button id="undo" onclick="undo()">Undo Last Delete</button> <button id="Save" onclick="saveData()">Save Points</button> <span id="updating-status" style="display: none">Updating...</span>
      </div>
      <div id="app">
         <table id="polygons-list" border="0">
            <tr>
               <th class="title-bar">Private Area</th>
               <th class="title-bar">Forbidden Place</th>
               <th class="title-bar">Parking List</th>
               <th class="title-bar">Road</th>
               <th class="title-bar">Parking with electric charges</th>
               <th class="title-bar">Side Path</th>
            </tr>
            <tr>
               <td id="privateList"></td>
               <td id="forbiddenList"></td>
               <td id="parkingList"></td>
               <td id="roadList"></td>
               <td id="parking_with_electric_chargesList"></td>
               <td id="side_pathList"></td>
            </tr>
         </table>
          <br>
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

    function getColor(index) {
        let clrs = {
            private: '#35BEEF',
            forbidden: '#FF0000',
            parking: '#F8E71C',
            road: '#03F6E6',
            parking_with_electric_charges: '#42E704',
            side_path: '#FFA500',
        };

        return clrs[index];
    }

    var canvas = document.querySelector("canvas");
    var c= canvas.getContext("2d");
    c.font = "16px Arial";
    ptext = "";
    var clickCount = 0;
    var type = document.querySelector('#type');
    var color = getColor(type.value);
    var col = hexToRgb(color);
    var rgbacolor = 'rgba('+col.r+','+col.g+', '+col.b+', 0.4)';
    c.fillStyle=rgbacolor;
    c.strokeStyle=color;
    type.addEventListener("change",()=>{
        color = getColor(type.value);
        col = hexToRgb(color);
        rgbacolor = 'rgba('+col.r+','+col.g+', '+col.b+', 0.4)';
        c.fillStyle=rgbacolor;
        c.strokeStyle=color;
    });
    var x,y;
    var error=5;
    var firstX,firstY;
    var i=0;
    var polygons=[];
    var points=[];
    var last_deleted_item  = null;

    document.querySelector("#clear").addEventListener("click",()=>{
        c.clearRect(0,0,canvas.offsetWidth,canvas.offsetHeight);
        polygons = [];
        points = [];
        clearPolygons();
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
                color: getColor(type.value),
                points: points
            });
            points = [];
            c.stroke();
            c.fill();
            c.closePath();
            ptext = "Polygon "+polygons.length+" ("+type.value+")";
            c.fillText(ptext,firstX,firstY);
            clickCount=0;
            i++;
            updatePolygonList();
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

   @foreach($drawables as $key=>$drawable)
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
             ptext = "Polygon "+({{$key+1}})+" ({{$drawable['type']}})";
             c.fillText(ptext,{{$point[0]}},{{$point[1]}});
             clickCount=0;
             i++;
             @continue
          @endif
             points.push([{{$point[0]}},{{$point[1]}}]);
             c.lineTo({{$point[0]}},{{$point[1]}});
             c.stroke();
       @endforeach
   @endforeach

   updatePolygonList();

    col = hexToRgb(getColor(type.value));
    rgbacolor = 'rgba('+col.r+','+col.g+', '+col.b+', 0.4)';
    c.fillStyle=rgbacolor;
    c.strokeStyle=getColor(type.value);

    function saveData() {
        $('#updating-status').show();
        axios.put("{{ action('CameraImageManagementController@updatePoints', $camera['cameraID']) }}", {
            polygons: polygons,
            _token: "{{ csrf_token() }}",
            _method: "put"
        }).then(function(response) {
            alert("Data updated successfully!");
            $('#updating-status').hide();
        }).catch(function(error) {
            alert('There was an error. Try again later!');
            $('#updating-status').hide();
        });
    }

    function clearPolygons() {
        $("#privateList").html("");
        $("#forbiddenList").html("");
        $("#parkingList").html("");
        $("#roadList").html("");
        $("#side_pathList").html("");
        $("#parking_with_electric_chargesList").html("");
    }

    function updatePolygonList() {
        clearPolygons();
        for (i=0;i<polygons.length;i++) {
            console.log(polygons[i]);
            let polygonType = polygons[i].type;
            let el = "<div style=\"padding: 5px;\">\n" +
                "Polygon "+(i+1)+" <button onclick=\"deletePolygon("+i+")\">Delete</button>\n" +
                "</div>";
            $("#"+polygonType+'List').append(el);
        }
    }

    function deletePolygon(index) {
        let pgs = [];
        for (i=0;i<polygons.length;i++) {
            if (index != i) {
                pgs.push(polygons[i]);
            } else {
                last_deleted_item = polygons[i];
                $('#undo').show();
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
                    ptext = "Polygon "+(i+1)+" ("+polygons[i].type+")";
                    c.fillText(ptext,x,y);
                    continue;
                }
                c.lineTo(x,y);
                c.stroke();
            }
        }
   }

   function undo() {
        if (last_deleted_item != null) {
            polygons.push(last_deleted_item);
            last_deleted_item = null;
            $('#undo').hide();
            c.clearRect(0,0,canvas.offsetWidth,canvas.offsetHeight);
            drawPolygonsFromBeginning();
            updatePolygonList();
        }
   }
</script>
</html>