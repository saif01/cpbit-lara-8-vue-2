<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Email Request Download</title>
    <link rel="stylesheet" href="{{ asset('all-assets\common\bootstrap-4.0\css\bootstrap.min.css') }}" />

</head>
<body>
    <div class="container-fluid" style="border: 3px solid black">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h3>Guest User Request</h3>
                <small>(Internet & Web Access)***By CPB's Policy</small>
                <h4>C.P Bangladesh Co., Ltd.</h4>
            </div>
            <div>
                <span class="font-weight-bold">CR No</span>
                <div>Date: <span>{{ date("F j, Y", strtotime($newData->date)) }}</span></div>
            </div>
        </div>


        <div class="my-5">
            <div class="h5 text-center py-2 bg-dark text-white w-50">Requester Information</div>
            <table class="table table-borderless">
                <tr>
                    <td>Name: <span>{{$newData->name}}</span></td>
                    <td>Branch/Operation: <span>{{$newData->branch}}</span></td>
                </tr>
                <tr>
                    <td>Position: <span>{{$newData->position}}</span></td>
                    <td>Department: <span>{{$newData->department}}</span></td>
                </tr>
                <tr>
                    <td>Personal Mobile: <span>{{$newData->mobile}}</span></td>
                    <td>Email: <span>{{$newData->personal_email}}</span></td>
                </tr>
            </table>
        </div>


        <div class="my-5">
            <div class="h5 text-center w-50 py-2 bg-dark text-white">Guest User Information</div>
            <table class="table table-borderless">
                <tr>
                    <td>Guest User Company: <span>{{$newData->guest_company}}</span></td>
                    <td>Number of Guest Users: <span> {{$newData->no_of_guest}} </span>User(s)</td>
                </tr>
                <tr>
                    <td colspan="2">Guest User Job: <span>{{$newData->guest_job}}</span></td>
                </tr>
                <tr>
                    <td>
                        Guest User Validity (Duration in Days) <span> {{$newData->guest_duration}} </span>Days(s)
                        <small>***validiy start after first login</small>
                    </td>
                    <td>Duration Date From: <span>{{$newData->start_date}}</span> to <span>{{$newData->end_date}}</span></td>
                </tr>
            </table>
        </div>

        <div>
            <div class="d-flex justify-content-between my-5">
                <div>
                    <div class="h5 text-center d-block py-2 bg-dark text-white">Requester</div>
                    <small>I Confirm that all the details provided in this form are correct & true</small>

                    <div class="mt-4">
                        Name: <span>{{$newData->name}}</span>
                    </div>
                    <div class="my-2">
                        Signature: <span>{{$newData->name}}</span>
                    </div>
                    <div class="d-flex">
                        <div class="mr-5">Date: <span>{{ date("F j, Y", strtotime($newData->date)) }}</span></div>
                        <div>Time: <span>{{ date("g:i a", strtotime($newData->date)) }}</span></div>
                    </div>
                </div>

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
                
            </div>

            <div class="d-flex justify-content-between">

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
                

                <div>
                    <div class="h5 text-center d-block py-2 bg-dark text-white">Finished By CPB-IT</div>
                    <small>I Confirm that all the details provided in this form are correct & true</small>

                    <div class="mt-4">
                        Name: 
                        <span>
                            @if (!empty($newData->emailschedule))
                                @if($newData->emailschedule->it_status == 1)
                                    {{ $newData->emailschedule->it_name }}
                                @endif
                            @else
                                <span class="text-error small"> Waiting For IT Approval </span>
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
                                <span class="text-error small"> Waiting For IT Approval </span>
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
                                    <span class="text-error small"> Waiting For IT Approval </span>
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
                                    <span class="text-error small"> Waiting For IT Approval </span>
                                @endif
                            </span>
                        </div>
                    </div>
                </div>

            </div>
        </div>

        <div class="my-4">
            <div>Expect to finish date within 3 working days after receive this form.</div>
            <textarea name="" id="" rows="7" class="form-control">
                Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ipsa odio dolor sit natus consequatur? Voluptatem maxime soluta nulla quidem aliquid iure, libero qui ea dolorem magnam quas sit quasi a!
            </textarea>
        </div>

        <small class="mt-5">CPB-IT-CR-3-REV.10</small>
        

    </div>
</body>
</html>