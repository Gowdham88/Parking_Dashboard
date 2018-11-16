<html>
<head>
   <title>Mask/Unmask</title>
   <style>
      * {
         padding: 0;
         margin: 0;
      }
   </style>
</head>
<body>
<div id="app">
   <canvas id="canvas" height="{{$height}}" width="{{$width}}" style="margin: 0 auto;background-image: url('{{ $camera['cameraImageUrl'] }}');background-size: cover"></canvas>
</div>
</body>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
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
            private: '#00FFFF',
            forbidden: '#FF0000',
            parking: '#00FF00',
            road: '#0000FF',
            parking_with_electric_charges: '#FFFF00',
        };

        return clrs[index];
    }

    var canvas = document.querySelector("canvas");
    var c= canvas.getContext("2d");
    c.font = "16px Arial";
    ptext = "";


    @foreach($drawables as $key=>$drawable)
        col = hexToRgb("{{$drawable['color']}}");
    rgbacolor = 'rgba('+col.r+','+col.g+', '+col.b+', 0.4)';
    c.fillStyle=rgbacolor;
    c.strokeStyle="{{$drawable['color']}}";
    @foreach($drawable['points'] as $point)
    @if ($loop->first)
    c.beginPath();
    c.lineTo({{$point[0]/2}},{{$point[1]/2}});
    c.stroke();
    c.fillRect({{$point[0]/2}},{{$point[1]/2}},3,3);
    @continue
    @endif
    @if ($loop->last)
    c.lineTo({{$point[0]/2}},{{$point[1]/2}});
    c.stroke();
    c.fill();
    c.closePath();
    ptext = "Polygon "+({{$key+1}})+" ({{$drawable['type']}})";
    c.fillText(ptext,{{$point[0]/2}},{{$point[1]/2}});
    clickCount=0;
    @continue
    @endif
    c.lineTo({{$point[0]/2}},{{$point[1]/2}});
    c.stroke();
   @endforeach
   @endforeach
</script>
</html>