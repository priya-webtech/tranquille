<html>
  <head>
    <meta charset="utf-8">
    <title></title>
  </head>
  <body>
    <table class="table table-bordered">
    	<thead>
            <tr>
                <th>No</th>
                <th>User Name</th>
                <th>Shop Name</th>
                <th>Amount</th>
                <th>Date</th>
            </tr>
        </thead>
        @if($payments) 
        	@foreach ($payments as $rows)
            	<tr>
            		<td>
			          {{$rows['	transaction_id']}}
			        </td>
			        <td>
			          {{$rows['userinfo']['name']}}
			        </td>
			        <td>
			          {{$rows['description']}}
			        </td>
			        <td>
			          {{$rows['amount']}}
			        </td>
			        <td>
			          {{$rows['transaction_at']}}
			        </td>
			      </tr>                          
            @endforeach     
        	
        @endif           
      
    </table>
  </body>
</html>