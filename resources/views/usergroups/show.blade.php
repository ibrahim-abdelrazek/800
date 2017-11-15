<div class="container">
    <div class="row">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class=""> {!! $usergroup->group_name !!}</h3>
            </div>

            <div class="panel-body">


                @php
                    $data = unserialize($usergroup->action);
                    $models = [
                        \App\Doctor::$model,
                        \App\Patient::$model,
                        \App\HotelGuest::$model,
                        \App\Nurse::$model,
                        \App\Order::$model,
                        \App\Product::$model,
                        \App\Transaction::$model
                        ] ;
                    $actions = ['view', 'add' ,'edit' ,'delete'];
                    $dataa =array();
                    foreach ($data as $k => $v){
                        $result = str_split($v);
                        $action= array();
                        $action[$actions[0]]= $result[0];
                        $action[$actions[1]]= $result[1];
                        $action[$actions[2]]= $result[2];
                        $action[$actions[3]]= $result[3];

                        $dataa[$k] = $action;

                     }

                @endphp

                <div class="table text-center">
                    <table class="table table-responsive">
                        <thead>
                        <th>Model</th>
                        @foreach ($actions  as $action )
                            <th>{{ $action }}</th>

                        @endforeach
                        </thead>

                        <tbody>
                        @foreach ($dataa as $k => $data)
                            <tr>
                                <td>{{ $k }}</td>

                                @foreach ($data as $d)
                                    @if($d == 1 )
                                        <td><span style="color:darkgreen">&#10004</span></td>
                                    @else
                                        <td><span style="color:darkred"> &#10006 </span></td>
                                    @endif
                                @endforeach
                            </tr>
                        @endforeach
                        <tr>

                        </tr>
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>
</div>