@extends('layouts.master')
@push('css')
<link href="https://fonts.googleapis.com/css2?family=Lato:wght@400;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
{{-- <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/le-frog/jquery-ui.css"> --}}
<link rel="stylesheet" href="{{asset('/css/aboutus-header_footer.css')}}">
<link rel="stylesheet" href="/css/modal/style.css">

<title>FG Expense - Profile</title>
@endpush

@section('content')
{{ Breadcrumbs::render('ministry', $ministry) }}

<link rel="stylesheet" href="{{ asset('css/ministry_report_comments.css') }}">
<link rel="stylesheet" href="{{asset('/css/ministry_list_table.css')}}">
<!-- Section-->
<div class="container d-flex centerize py-4">
    <div class="ministry-logo d-flex ">
        <img src="{{asset('/img/image_7.png')}}" class="ministry-logo-image" alt="ministry logo">
    </div>
    <div class="ministry">
        <h1 class="font-weight-bold">{{$ministry->name}}</h1>
    </div>
</div>

<div class="container intro mb-4 mt-4">
    <div class="row stats">
        <div class="col">
            <p>Ministry Twitter Handle</p>
            
            @php
                $ministryHandle = substr($ministry->twitter, 1)   
            @endphp
            <div class="sub"><h4 id="minwrks" class="twitter-link"> <a href="{!! url("https://twitter.com/$ministryHandle") !!}">{{$ministry->twitter}}</a></h4>
                 <small>{{date('Y')}}</small></div>
        </div>
        <div class="col">
            <p>Total Amount Spent</p>
            <h4><span class="text-success">&#8358;{{number_format($trend["2020"], 2)}}</span></h4>
            <small>{{date('Y')}}</small>
        </div>
        <div class="col">
            <p>Total Number of Projects</p>
            <h4><span class="text-success">{{count($payments)}}</span></h4>
            <small>{{date('Y')}}</small>
        </div>
    </div>

</div>

<div class="list">
    <!--Tabs Header-->
    <ul class="nav container nav-tabs switch-list py-3 mb-3">
        <li class="ml-3 tabs active"><a data-toggle="tab" class="active" href="#expense">Expense Summary</a></li>
        <li class="tabs"><a data-toggle="tab" href="#board">Cabinet</a></li>
        <li class="tabs"><a data-toggle="tab" href="#comments">Comments</a></li>
    </ul>

    <hr>
    <!--Tab Body-->
    <div class="tab-content">

        <!--1-->
        <div id="expense" class="tab-pane fade show active">

            <div>
                <div id="table-border" class="container pt-3 mt-4 pb-3">
                    <div class="container pb-3 pt-1 py-4">
                        <div class="row centerize">
                            <div class="col">
                                <h3 id="said-date" class="index">Date: {{date("jS F, Y")}}</h1>
                            </div>

                            <div class="col">
                               
                                <button type="button"  data-toggle="modal" data-target="#filterModal" class="btn btn-success filter"> Select Date <img
                                        src="/img/vector__2_.png"></button>
                            </div>
                        </div>
                    </div>

                     <!-- Filter Modal -->
                    <div id="modal" class="row justify-content-center">
                        <div class="col-md-8">
                            <div class="modal fade" id="filterModal" tabindex="-1" role="dialog" aria-labelledby="filterModalLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <!-- Header -->
                                    <div class="modal-header">
                                    <h5 class="modal-title" id="filterModalLabel">Filter</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                    </div>
                                    <!-- Body -->
                                    <div class="modal-body">
                                        <section>
                                            <p id="view" class="font-weight-bold">View by</p>
                                            <div id="date-btn" class="row">
                                                <div class="col-4">
                                                <button id="day" class="btn btn-block btn-date active">Day</button>
                                                </div>
                                                <div class="col-4">
                                                <button id="month" class="btn btn-block btn-date">Month</button>
                                                </div>
                                                <div class="col-4">
                                                <button id="year" class="btn btn-block btn-date">Year</button>
                                                </div>
                                            </div>
                                        </section>                   
                                        <br>
                                        <section class="row">
                                            <div class="col-12" style="position:relative">
                                            <i class="fa fa-calendar" aria-hidden="true"></i>
                                            <input placeholder="Select Date" name="select-date" id="select-date"  class="form-control">
                                            <input placeholder="Select Month" name="select-month" id="select-month" class="monthYearPicker form-control" />
                                            <input placeholder="Select Year" name="select-year" id="select-year" class="yearPicker form-control" />
                                            <small id="date-format-err"></small>
                                        </section>
                                        <br>
                                        <section id="sort-options">
                                            <p class="font-weight-bold">Sort by</p>
                                            <div>
                                                <button id="desc" class="btn btn-block btn-amount">Amount (Highest to Lowest)</button>
                                                <button id="asc" class="btn btn-block btn-amount">Amount (Lowest to Highest)</button>
                                            </div>
                                        </section>
                                    </div>
                                    <!-- Footer -->
                                    <div class="modal-footer">
                                    <button type="button" data-id="{{$ministry->id}}" id="apply-filter" class="btn btn-block active mx-5" data-dismiss="modal">Apply Filter</button>
                                    </div>
                                </div>
                                </div>
                            </div>
                        </div>
                    </div>
                     <!-- End of Filter Modal -->

                    <div class="container">
                        <div class="table-div">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th scope="col">Project</th>
                                        <th scope="col">Company</th>
                                        <th scope="col">Amount</th>
                                        <th scope="col">Date</th>
                                    </tr>
                                </thead>

                                <tbody id="expense-table">
                                    @if (count($payments) > 0)
                                        @php
                                        $back = true;
                                        @endphp
                                        @foreach($payments as $payment)
                                    
                                        @php
                                        $back = !$back;
                                        $shade = $back ? 'back': '';
                                        @endphp
                                            <tr  class="{{$shade}}">
                                                <td> {{$payment->description}}</td>
                                                <td> {{$payment->beneficiary}}</td>
                                                <td> ₦{{number_format($payment->amount, 2)}}</td>
                                                <td> {{date('jS, M Y', strtotime($payment->payment_date))}}</td>
                                            </tr>
                                        @endforeach
                                @endif
                                
                                </tbody>

                            </table>
                        </div>

                        <div class="row centerize mt-3 pt-3">
                            <div class="col-md result text-muted"> 1-20 of 320 results</div>
             
                                <div class="pagination">
                                    <a href="#">&laquo;</a>
                                    <a class="active" href="#">1</a>
                                    <a href="#">2</a>
                                    <a href="#">3</a>
                                    <a href="#">4</a>
                                    <a href="#">...</a>
                                    <a href="#">6</a>
                                    <a href="#">&raquo;</a>
                                </div>
                          
                        </div>
                    </div>

                </div>

                <div class="mt-5 mb-5">
                    <div class="container mt-5">
                        <div class="min-tab">
                            <div class="row">
                                <table class="minitable table-bordered">
                                    <thead class="thead">
                                        <th class="first-th text-white"> YEAR</th>
                                       
                                        @foreach($trend as $key => $value)
                                            <th>{{$key}}</th>
                                        @endforeach
                                       
                                    </thead>

                                    <tbody>
                                        <tr>
                                            <td class="text-success"> TOTAL<br>AMOUNT </td>
                                            
                                            @foreach($trend as $key => $value)
                                             <td>₦{{ number_format($value, 2) }}</td>
                                            @endforeach
    
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                            
                    </div>
                </div>
            </div>
        </div>


    <!--2-->
    <div id="board" class="tab-pane fade">
        <div class="row my-5 pl-3 d-flex justify-content-lg-around">
            @if ($cabinets)
                @foreach($cabinets as $cabinet)
                @php
                    $ministerHandle = substr($cabinet->twitter, 1)
                @endphp
            <div class="col-lg-3 card border-top-0 border-left-0 border-right-0">
                <div class="card-img" style="display:flex; justify-content: center; padding:1.25rem 1.25rem 0;">
                    <img src="{{$cabinet->avatar}}" class="img-fluid" alt="{{$cabinet->name}}">
                </div>
                <div class="card-body">
                    <div class="card-title">
                    <p id="minister-name" class="text-center font-weight-bold">{{$cabinet->name}}</p>
                    <p class="text-success text-center">{{$cabinet->role}}</p>
                    </div>
                    
                        
                       
                
                    <div class="social-handle text-center">
                        <a href="#" class="link"><i class="fab fa-facebook" aria-hidden="true"></i></a>
                        <a href="{!! url("https://twitter.com/$ministerHandle") !!}" class="link ml-2"><i class="fab fa-twitter" aria-hidden="true"></i></a>
                        <a href="#" class="link ml-2"><i class="fab fa-linkedin" aria-hidden="true"></i></a>
                        <a href="#" class="link ml-2"><i class="fab fa-instagram" aria-hidden="true"></i></a>
                    </div>
                </div>
            </div>
            
                @endforeach
            @endif
        </div>

    </div>

    <!--3-->
        <div id="comments" class="tab-pane fade">
            @include('partials.comments')
        </div>
    </div>
</div>
{{-- ministry cabinet member suggestion --}}
<div class='container'>
    <!-- Modal to Enter Form -->
    <h3 style='color: #353A45; text-align:center;margin-top: 15px'>Suggest Cabinet Members</h3>
`     
<center>
<button type="button" class="btn btn-success" data-toggle="modal" data-target="#myModal" style="background: 353A45;margin-bottom: 20px;">
Suggest a Cabinet Member
</button>
</center>
<!-- Modal -->
    @if ($errors->any())
      <div class="alert alert-danger">
          <ul>
              @foreach ($errors->all() as $error)
                  <li>{{ $error }}</li>
              @endforeach
          </ul>
      </div>
  @endif
<!-- The Modal -->
<div class="modal" id="myModal">
<div class="modal-dialog">
<div class="modal-content">

  <!-- Modal Header -->
  <div class="modal-header">
    
    <button type="button" class="close" data-dismiss="modal">&times;</button>
  </div>

  <!-- Modal body -->
  <div class="modal-body">
  <form  action=" {!! url('/feedback') !!}" method="POST">
    {{csrf_field()}}
    <div class="form-group">
      <label for="firstName">Firstname</label>
      <input type="text" name="firstName" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Firstname">
    </div>
    <div class="form-group">
      <label for="lastName">Lastname</label>
      <input type="text" name="lastName" class="form-control" id="exampleInputPassword1" placeholder="Lastname">
    </div>
    
    <div class="form-group">
      <label for="ministry">Select Cabinet</label>
      <select id="inputState" class="form-control" name="ministry_id">
        <option selected value="1">Works</option>
        <option value="Housing">Housing</option>
        <option value="Interior">Interior</option>
        <option value="Petroleum">Petroleum</option>
        <option value="Finance">Finance</option>
        <option value="Power">Power</option>
        <option value="Health">Health</option>
        <option value="Labour">Labour</option>
        <option value="Environment">Environment</option>
        <option value="Water Resouirces">Water Resouirces</option>
        <option value="Communication">Communication</option>
        <option value="Aviation">Aviation</option>
        <option value="Defense">Defense</option>
        <option value="Information">Information</option>
        <option value="Youths and Sports">Youths and Sports</option>
        <option value="Police Affairs">Police Affairs</option>
        <option value="Education">Education</option>
        <option value="Justice">Justice</option>
        <option value="Agriculture">Agriculture</option>
        <option value="Women Affairs">Women Affairs</option>
      </select>
    </div>
   <center>
    <button type="submit" class="btn btn-primary ">Submit</button>
  </center>

  </form>


  </div>

  
</div>
</div>
</div>
@endsection


@section('js')
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script src="{{ asset('js/ministry_profile.js') }}" type="text/javascript"></script>
@endsection