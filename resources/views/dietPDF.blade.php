
<!DOCTYPE html>
<html>
   <body style="font-family: sans-serif;background: rgb(253,223,213); background: linear-gradient(0deg, rgba(253,223,213,1) 0%, rgba(208,207,218,1) 100%);">
      <div style="max-width: 1000px; margin: 0 auto;">
         <h2 style="font-size: 35px; color: #000; text-align: center; font-weight: 700;">DIET CHART</h2>
         <h3 style="font-size: 20px; color: #000; font-weight: 600;">Name: {{ $title }}</h3>
         <h3 style="font-size: 20px; color: #000; font-weight: 600; margin-bottom:20px;">Date: {{ $date }}</h3>
         <table style="width:100%; border-collapse:collapse; background: #fff;" border="1">
            <tr>
               <th style="font-size: 25px; padding:10PX 20PX; text-align: left;">Frequency</th>
               <th style="font-size: 25px; padding:10PX 20PX;">Meal</th>
               <th style="font-size: 25px; padding:10PX 20PX;">Quantity</th>
            </tr>
            @foreach($customarr1 as $key => $item)
            <tr>
               <td style="font-size: 25px; color: #262262; padding:40PX 20PX; font-weight: 600; width: 200px;">{{$item['frequency_name']}}</td>
                <td style="text-align:center;">
                    @foreach($item['meal'] as $key2 => $item2)
                    {{$key2+1}}. {{$item2['meal_name']}} <br> 
                    @endforeach 
                </td>
                <td style="text-align:center;">
                    @foreach($item['meal'] as $key2 => $item2)
                    {{$item2['quantity']}} <br> 
                    @endforeach 
                </td>
            </tr>
            @endforeach
            
         </table>
         <p style="font-size: 35px; color: #262262; text-align: center; font-weight: 600;">"DONT EAT LESS EAT RIGHT"</p>
      </div>
   </body>
</html>