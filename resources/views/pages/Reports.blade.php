@extends('layouts.app')
@section('content')

<div>
<button 
		class="btn btn-success btn-xs" type="submit" value="Add another row" onclick="addRow(this)">ExportToExcel
</button>
</div>
<table>
        <tr>
          <th>Camera Id</th>
          <th>Camera Lat-Long</th>
          <th>No. of bookings</th>
          <th>No. of Users</th>
        </tr>
        <tr>
          <td>CAM001</td>
          <td>12.900988,80.227928</td>
          <td>120</td>
          <td>100</td>
        </tr>
        <tr>
          <td>CAM002</td>
          <td>17.900988,85.227928</td>
          <td>150</td>
          <td>130</td>
        </tr>
        <tr>
          <td>CAM003</td>
          <td>14.900988,81.227928</td>
          <td>78</td>
          <td>50</td>
        </tr>   
      </table>

@stop