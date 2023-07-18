
{{-- this is the main container  --}}
 <main class="d-flex justify-content-center row main-row">

    {{-- This is used for paragraph container  --}}
    <div class="para col">
        <p class="fs-3 text-center">Confirmed Order</p>
    </div>
    <div class="information-container">    
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">S.N</th>
                    <th scope="col">Products</th>
                    <th scope="col">Price</th>
                    <th scope="col">Quantity</th>
                </tr>
            </thead>
            @php
                $count = 0;
            @endphp
            <tbody>
                {{-- @foreach ($userorders as $index => $userOrder) --}}
                @php
                // count the total number of elements in the json object
                $count = count(json_decode($userOrder->order_details));
                // dd(json_decode($userOrder->order_details));
                $i = 0;
                if($count == 0 )
                {
                    return;
                }
                @endphp

                    <tbody>
                        @foreach (json_decode($userOrder->order_details) as $order)
                       @php
                           ++$i;
                       @endphp 
                        <tr scope='row'>
                            <td>{{$i}}</td>        
                                <td>{{$order->name }}</td>
                                <td>{{$order->price}}</td>
                                <td>{{$order->quantity}}</td>
                        </tr>
                                                                        
                       @endforeach
                       
                    </tbody>
                    
                    
                    <tr class="col">
                        <td colspan="4">
                            <p class="fs-5 text-end m-3 text-success">
                                Total : {{$userOrder->total}}
                            </p>
                        </td>
                    </tr>                    
          
            </tbody>
        </table>
        
        <button class="btn btn-primary" id="element-to-print" onclick="generatePDF()">
            Download Receipt
        </button>
    </div>
</main>
