<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Email Request Download</title>
    <link rel="stylesheet" href="{{ asset('all-assets\common\bootstrap-4.0\css\bootstrap.min.css') }}" />

</head>
<body>
    <div class="container-fluid" style="border:3px solid black">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h3>Internet/Web Access Request</h3>
                <h4>C.P Bangladesh Co., Ltd.</h4>
            </div>
            <div>
                Date:  <span>{{ date("F j, Y", strtotime($newData->date)) }}</span>
            </div>
        </div>


        <div class="my-5">
            <div class="h5 text-center w-50 py-2 bg-dark text-white">User Information</div>
            <div class="table-responsive">
                <table class="table table-borderless">

                    <tr>
                        <td>Name: <span>{{$newData->name}}</span></td>
                        <td>Branch: <span>{{$newData->branch}}</span></td>
                    </tr>
                    <tr>
                        <td>Position: <span>{{$newData->position}}</span></td>
                        <td>Department: <span>{{$newData->department}}</span></td>
                    </tr>
                    <tr>
                        <td>Personal Mobile:
                            <span>
                                @if($newData->personal_mobile)
                                    {{ $newData->personal_mobile }}
                                @else
                                    N/A
                                @endif
                            </span>
                        </td>
                        <td>Office Mobile:
                            <span>
                                @if($newData->office_mobile)
                                    {{ $newData->office_mobile }}
                                @else
                                    N/A
                                @endif
                            </span>
                        </td>
                    </tr>
                    <tr>
                        <td>Personal Email:
                            <span>
                                @if($newData->personal_email)
                                    {{ $newData->personal_email }}
                                @else
                                    N/A
                                @endif
                            </span>
                        </td>
                        <td>Office Email: 
                            <span>
                                @if($newData->office_email)
                                    {{ $newData->office_email }}
                                @else
                                    N/A
                                @endif
                            </span>
                        </td>
                    </tr>
                </table>
            </div>
        </div>


        <div>
            <div>Do you have any ID <b>like shayful.lam</b> for Smart Soft, Smart Procurement, Win Feed, Win Farm or other?</div>
            <div>
                <span class="font-weight-bold">
                    @if($newData->internet_id)
                        {{ $newData->internet_id }}
                    @else
                        No
                    @endif
                </span>
            </div>
        </div>

        <div class="my-5">
            <div class="h5 text-center w-50 py-2 bg-dark text-white">Request For</div>
            <div class="my-2">{{$newData->request_for}}</div>
        </div>

        <div class="my-5">
            <div class="d-flex justify-content-between">
                <div>
                    <div class="h5 text-center py-2 bg-dark text-white d-block">Web Access (URL)</div>
                    <textarea name="" id="" rows="7" cols="60" class="form-control">
                        {{$newData->web_url}}
                    </textarea>
                </div>

                <div>
                    <div class="h5 text-center py-2 bg-dark text-white d-block">Purpose</div>
                    <textarea name="" id="" rows="7" cols="60" class="form-control">
                        {{$newData->purpose}}
                    </textarea>
                </div>
            </div>
        </div>

        <div>
            <div class="d-flex justify-content-between my-5">
                <div>
                    <div class="h5 text-center d-block py-2 bg-dark text-white">User</div>
                    <small>I Confirm that all the details provided in this form are correct & true</small>

                    <div class="mt-4">
                        Name: <span>{{$newData->name}}</span>
                    </div>
                    <div class="my-2">
                        Signature: <span>{{$newData->name}}</span>
                    </div>
                    <div class="d-flex">
                        <div class="mr-5">Date:  <span>{{ date("F j, Y", strtotime($newData->date)) }}</span></div>
                        <div>Time:  <span>{{ date("g:i a", strtotime($newData->date)) }}</span></div>
                    </div>
                </div>

                <div>
                    <div class="h5 text-center d-block py-2 bg-dark text-white">Agreed By Manager</div>
                    <small>I Confirm that all the details provided in this form are correct & true</small>

                    <div class="mt-4">
                        Name: 
                        <span>
                            @if (!empty($newData->emailschedule))
                                @if($newData->emailschedule->manager_status == 1)
                                    {{ $newData->emailschedule->manager_name }}
                                @endif
                            @else
                                <span class="text-error small">Waiting for Your Approval</span>
                            @endif
                        </span>
                    </div>
                    <div class="my-2">
                        Signature: 
                        <span>
                            @if (!empty($newData->emailschedule))
                                @if($newData->emailschedule->manager_status == 1)
                                    {{ $newData->emailschedule->manager_name }}
                                @endif
                            @else
                                <span class="text-error small">Waiting for Your Approval</span>
                            @endif
                        </span>
                    </div>
                    <div class="d-flex">
                        <div class="mr-5">Date: 
                            <span>
                                @if (!empty($newData->emailschedule))
                                    @if($newData->emailschedule->manager_status == 1)
                                        {{ date("F j, Y", strtotime($newData->emailschedule->manager_datetime)) }}
                                    @endif
                                @else
                                    <span class="text-error small">Waiting for Your Approval</span>
                                @endif
                            </span>
                        </div>
                        <div>Time: 
                            <span>
                                @if (!empty($newData->emailschedule))
                                    @if($newData->emailschedule->manager_status == 1)
                                        {{ date("g:i a", strtotime($newData->emailschedule->manager_datetime)) }}
                                    @endif
                                @else
                                    <span class="text-error small">Waiting for Your Approval</span>
                                @endif
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="d-flex justify-content-between">

                <div>
                    <div class="h5 text-center d-block py-2 bg-dark text-white">Approved By BU Head</div>
                    <small>I Confirm that all the details provided in this form are correct & true</small>

                    <div class="mt-4">
                        Name: 
                        <span>
                            @if (!empty($newData->emailschedule))
                                @if($newData->emailschedule->bu_status == 1)
                                    {{ $newData->emailschedule->bu_name }}
                                @endif
                            @else
                                <span class="text-error small"> Waiting For Manager Approval </span>
                            @endif
                        </span>
                    </div>
                    <div class="my-2">
                        Signature: 
                        <span>
                            @if (!empty($newData->emailschedule))
                                @if($newData->emailschedule->bu_status == 1)
                                    {{ $newData->emailschedule->bu_name }}
                                @endif
                            @else
                                <span class="text-error small"> Waiting For Manager Approval </span>
                            @endif
                        </span>
                    </div>
                    <div class="d-flex">
                        <div class="mr-5">Date: 
                            <span>
                                @if (!empty($newData->emailschedule))
                                    @if($newData->emailschedule->bu_status == 1)
                                        {{ date("F j, Y", strtotime($newData->emailschedule->bu_datetime)) }}
                                    @endif
                                @else
                                    <span class="text-error small"> Waiting For Manager Approval </span>
                                @endif
                            </span>
                        </div>
                        <div>Time: 
                            <span>
                                @if (!empty($newData->emailschedule))
                                    @if($newData->emailschedule->bu_status == 1)
                                        {{ date("g:i a", strtotime($newData->emailschedule->bu_datetime)) }}
                                    @endif
                                @else
                                    <span class="text-error small"> Waiting For Manager Approval </span>
                                @endif
                            </span>
                        </div>
                    </div>
                </div>

                <div>
                    <div class="h5 text-center d-block py-2 bg-dark text-white">Received By CPB-IT</div>
                    <small>I Confirm that all the details provided in this form are correct & true</small>

                    <div class="mt-4">
                        Name: 
                        <span>
                            @if (!empty($newData->emailschedule))
                                @if($newData->emailschedule->it_status == 1)
                                    {{ $newData->emailschedule->it_name }}
                                @endif
                            @else
                                <span class="text-error small"> Waiting For BU Approval </span>
                            @endif
                        </span>
                    </div>
                    <div class="my-2">
                        Signature: 
                        <span>
                            @if (!empty($newData->emailschedule))
                                @if($newData->emailschedule->it_status == 1)
                                    {{ $newData->emailschedule->it_name }}
                                @endif
                            @else
                                <span class="text-error small"> Waiting For BU Approval </span>
                            @endif
                        </span>
                    </div>
                    <div class="d-flex">
                        <div class="mr-5">Date: 
                            <span>
                                @if (!empty($newData->emailschedule))
                                    @if($newData->emailschedule->it_status == 1)
                                        {{ date("F j, Y", strtotime($newData->emailschedule->it_datetime)) }}
                                    @endif
                                @else
                                    <span class="text-error small"> Waiting For BU Approval </span>
                                @endif
                            </span>
                        </div>
                        <div>Time: 
                            <span>
                                @if (!empty($newData->emailschedule))
                                    @if($newData->emailschedule->it_status == 1)
                                        {{ date("g:i a", strtotime($newData->emailschedule->it_datetime)) }}
                                    @endif
                                @else
                                    <span class="text-error small"> Waiting For BU Approval </span>
                                @endif
                            </span>
                        </div>
                    </div>
                </div>

            </div>
        </div>

        <small>CPB-IT-CR-3-REV.10</small>
        

    </div>
</body>
</html>