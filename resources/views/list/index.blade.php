@extends('main')

@section('content')

    <div class="row">

        <div class="col-md-12">
            <span style="font-weight:900; font-size: 20px;">{{ Auth::user()->name }}님 요금 관리 페이지</span>

            @if (Auth::user()->name === 'admin')

                <span class="pull-right" style="margin-bottom: 5px;">
                        <a href="#" class="btn btn-info" onClick="return popitup('deposit')">Deposit</a>
                    </span>

            @else

            @endif

            <div class="col-md-12">





                <form action="" method="GET" onsubmit="search()" id="frmsearch">

                    <table class="table tabled-bordered" style="margin-bottom: 0px;">
                        <tr>

                            <td style="padding-top: 12px;width: 416px;">
                                <input type="text" name="dateFrom" id="datepicker1" class="span3" value="{{ Request::get('from', Request::get('dateFrom', \Carbon\Carbon::now()->format('Y-m-d'))) }}" readonly style="display: inline-block;"> ~
                                <input type="text" name="dateTo" id="datepicker2" class="span3" value="{{ Request::get('to', Request::get('dateTo', \Carbon\Carbon::now()->format('Y-m-d'))) }}" readonly style="display: inline-block;">
                            </td>
                            <td style="width: 616px;">
                                <button type="submit" class="btn btn-search btn-block">
                                    <i class="fa fa-search"></i>Search
                                </button>
                            </td>
                            <td>
                                <a href="{{ url('excel') . '?' . http_build_query($params) }}" class="btn btn-warning">Excel</a>
                            </td>
                        </tr>
                    </table>

                </form>

            </div>




        <div class="col-md-12">

            <table id="mytable" class="table table-bordered table-striped">
                <thead>
                <tr>
                    <th>IDX</th>
                    <th>발신번호</th>
                    <th>착신번호</th>
                    <th>통화결과</th>
                    <th>통화시간</th>
                    <th>발신시간</th>
                    <th>통화날짜</th>
                    <th>billsec</th>
                    <th>착신종류</th>
                    <th>도수</th>
                    <th>요금</th>
                </tr>
                </thead>
                <tbody>
                @foreach ($cdrs as $cdr)
                    <tr>
                        <td>{{ str_replace('-','',(($cdrs->currentpage()-1) *15) - ($cnt--))  }}</td>
                        <td>{{ $cdr->src }}</td>
                        <td>{{ $cdr->dst }}</td>
                        <td>{{ $cdr->disposition }}</td>
                        <td>{{ $cdr->duration }}</td>
                        <td>{{ substr($cdr->calldate,11,10) }}</td>
                        <td>{{ substr($cdr->calldate,0,10) }}</td>
                        <td>{{ $cdr->billsec }}</td>
                        <td>{!! $cdr->getType() !!}</td>
                        <td>{{ $cdr->getUnit() }}</td>
                        <td>{{ $cdr->getPrice() }}</td>
                        {{--<td>{{ $cdr->getPrice() == 0 ? $cdr->getprice() : number_format($cdr->getprice(),1)  }}</td>--}}
                        {{--<td>{{ number_format($cdr->getPrice(), 1,'.',',') }}</td>--}}
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>

        <div>
            <p>남은 금액 : {{ number_format($deposits_total - $total - 25175523.5 - 32832) }}</p>
        </div>

        <div class="text-center">
            {{ $cdrs->appends(Request::all())->links() }}
        </div>
    </div>

    <script>
        function popitup(url)
        {
            newwindow=window.open(url,'name','height=300,width=650,screenX=400,screenY=350');
            if (window.focus) {newwindow.focus()}
            return false;
        }
    </script>

@endsection
