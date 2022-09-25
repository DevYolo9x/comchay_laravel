<?php
$id = $data['id'];
$detail = \App\Models\TourBook::find($id);
use App\Components\System;
$system = new System();
$fcSystem = $system->fcSystem();
?>
<table width="100%" cellpadding="0" cellspacing="0" border="0" dir="ltr" align="center"
    style="background-color:#fff;font-size:16px">
    <tb>
        <tr>
            <td align="left" valign="top" style="margin:0;padding:0">
                <table align="center" border="0" cellspacing="0" cellpadding="0" width="720" bgcolor="#ffffff">
                    <tbody>
                        <tr>
                            <td>
                                <div
                                    style="border:2px solid #2f5acf;padding:8px 16px;border-radius:16px;margin-top:16px">
                                    <p style="margin:10px 0 20px;font-weight:bold;font-size:20px">
                                        INQUIRY
                                        <a href="javascript:void(0)">
                                            #{{$detail->code}}
                                        </a>
                                        <span style="font-weight:normal">({{$detail->created_at}})</span>
                                    </p>
                                    <table cellpadding="0" cellspacing="0" border="0" width="100%">
                                        <tbody>
                                            <tr>
                                                <td valign="top">
                                                    <p style="margin:10px 0;font-weight:bold">
                                                        <b>Thông tin khách hàng</b>
                                                    </p>
                                                    <p style="margin:10px 0">
                                                        Full Name: {{$detail->fullname}}
                                                    </p>
                                                    <p style="margin:10px 0">
                                                        Email Adress: <a href="mailto:{{$detail->email}}"
                                                            target="_blank">{{$detail->email}}</a>
                                                    </p>
                                                    <p style="margin:10px 0">
                                                        Phone: <a href="tel:{{$detail->phone}}"
                                                            target="_blank">{{$detail->phone}}</a>
                                                    </p>
                                                    <?php echo $detail->inquiryTour?>
                                                    <p style="margin:10px 0">
                                                        Message: {{$detail->message}}
                                                    </p>
                                                </td>
                                            </tr>

                                        </tbody>
                                    </table>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
                <table align="center" border="0" cellspacing="0" cellpadding="0" width="720" bgcolor="#ffffff">
                    <tbody>
                        <tr>
                            <td style="font-size:14px;text-align:center;padding:16px 0;line-height:20px">
                                Hotline: <a href="tel:{{$fcSystem['contact_hotline']}}"
                                    style="color:black;text-decoration:none"
                                    target="_blank">{{$fcSystem['contact_hotline']}}</a> |
                                CSKH: <a href="mailto:{{$fcSystem['contact_email']}}"
                                    style="color:black;text-decoration:none"
                                    target="_blank">{{$fcSystem['contact_email']}}</a>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </td>
        </tr>
    </tb ody>
</table>
