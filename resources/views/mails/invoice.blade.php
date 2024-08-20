<x-mail-base>
    <!-- Your e-mail content -->
    <table style="width: 100%;" style="border: 1px solid gray; ">
        <tbody>
            <tr>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
            </tr>
            <tr>
                <td colspan="6" style="text-align: center; font-weight: bold;">
                    SCHENKER DISTRIBUTION SOLUTIONS INC
                </td>
            </tr>
            <tr>
                <td colspan="6" style="text-align: center;">
                    KM19 Sabrina Compound, West Service Road, Marcelo Green Vill. Brgy. Marcelo Green, Paranaque City 1713
                </td>
            </tr>
            <tr>
                <td colspan="6" style="text-align: center;">
                    VAT Registered TIN: 008-705-884-0000
                </td>
            </tr>
            <tr>
                <td colspan="6" style="text-align: center;">
                    Business Style: SCHENKER DISTRIBUTION SOLUTIONS INC
                </td>
            </tr>
            <tr>
                <td colspan="6" style="text-align: center;">
                    Telephone No: 8249-8638
                </td>
            </tr>
            <tr>
                <td colspan="6">&nbsp;</td>
            </tr>
            <tr>
                <td style="width: 100px; text-align: right">OR No.:</td>
                <td style="width: 100px;">{{ $payload['header']['formatted_id'] }}</td>
                <td colspan="4">&nbsp;</td>
            </tr>
            <tr>
                <td style="width: 100px; text-align: right">Date:</td>
                <td style="width: 100px;"> {{ $payload['header']['formatted_date'] }} </td>
                <td colspan="4">&nbsp;</td>
            </tr>
            <tr>
                <td colspan="6">&nbsp;</td>
            </tr>
            <tr>
                <td style="width: 100px;">Customer Name:</td>
                <td style="width: 200px;"> {{ $payload['header']['account'] ? $payload['header']['account']['name'] : '-' }} </td>
                <td style="width: 300px; text-align: right">Business Style:</td>
                <td colspan="3"> {{ $payload['header']['account'] ? $payload['header']['account']['name'] : '-' }} </td>
            </tr>
            <tr>
                <td style="width: 100px;">Address:</td>
                <td style="width: 200px;">{{ $payload['header']['account'] ? $payload['header']['account']['address'] : '-' }}</td>
                <td style="width: 300px; text-align: right">T.I.N.:</td>
                <td colspan="3">{{ $payload['header']['account'] ? $payload['header']['account']['tin'] : '-' }}</td>
            </tr>
            <tr>
                <td colspan="6">&nbsp;</td>
            </tr>
            <tr style="text-align: center;">
                <td class="border" colspan="2">DESCRIPTION</td>
                <td class="border" style="width: 100px;">Tx Type</td>
                <td class="border" style="width: 100px;">INVOICE/S</td>
                <td class="border" style="width: 100px;"></td>
                <td class="border">AMOUNT</td>
            </tr>
            <tr style="text-align: center;">
                <td class="border" colspan="2">Services</td>
                <td class="border" style="width: 100px;">A1</td>
                <td class="border" style="width: 100px;">various #3 collex details</td>
                <td class="border" style="width: 100px;"></td>
                <td class="border">273990444.51</td>
            </tr>
            <tr style="text-align: center;">
                <td class="border" colspan="2">Container Deposit</td>
                <td class="border" style="width: 100px;">AE</td>
                <td class="border" style="width: 100px;"></td>
                <td class="border" style="width: 100px;"></td>
                <td class="border">476259481.980009</td>
            </tr>
            <tr style="text-align: center;">
                <td class="border" colspan="2">Services</td>
                <td class="border" style="width: 100px;">A0</td>
                <td class="border" style="width: 100px;"></td>
                <td class="border" style="width: 100px;"></td>
                <td class="border">559169790.470004</td>
            </tr>
            <tr>
                <td colspan="6">&nbsp;</td>
            </tr>
            <tr>
                <td colspan="6">&nbsp;</td>
            </tr>

            <tr>
                <td colspan="2" style="width: 50%;">
                    <div style="text-align: center;">
                        TAX INFORMATION
                    </div>
                    <table style="width: 100%;">
                        <tr>
                            <td>VATable Sales</td>
                            <td class="text-right" style="width: 200px;">
                                {{ $payload['header']['formatted_vatable_sales'] }}
                            </td>
                        </tr>
                        <tr>
                            <td>VAT (12%)</td>
                            <td class="text-right" style="200px;">
                                {{ $payload['header']['formatted_vat_amount'] }}
                            </td>
                        </tr>
                        <tr>
                            <td>Zero-Rated Sales</td>
                            <td class="text-right" style="200px;">
                                {{ $payload['header']['formatted_zero_rated'] }}
                            </td>
                        </tr>
                        <tr>
                            <td>VAT-Exempt Sales</td>
                            <td  class="border-b text-right" style="200px;">
                                {{ $payload['header']['formatted_vat_exempt'] }}
                            </td>
                        </tr>
                        <tr>
                            <td class="bold">Total Sales</td>
                            <td class="text-right" style="200px;">
                                {{ $payload['header']['formatted_vat_exempt'] }}
                            </td>
                        </tr>
                        <tr>
                            <td>Less: SC/PWD Discount</td>
                            <td  class="border-b text-right" style="200px;">
                                {{ $payload['header']['formatted_sc_pwd_discount'] }}
                            </td>
                        </tr>
                        <tr>
                            <td class="bold">Total Due</td>
                            <td class="text-right" style="200px;">
                                {{ $payload['header']['formatted_net_due'] }}
                            </td>
                        </tr>
                        <tr>
                            <td>Less: Withholding Tax</td>
                            <td  class="border-b text-right" style="200px;">
                                -
                            </td>
                        </tr>
                        <tr>
                            <td class="bold">TOTAL AMOUNT PAID</td>
                            <td class="text-right" style="200px;">
                                {{ $payload['header']['formatted_net_amount'] }}
                            </td>
                        </tr>
                    </table>
                </td>
                <td >&nbsp;</td>
                <td colspan="3" style="width: 50%; ">
                    <div style="text-align: center;">
                        RA 9994
                    </div>
                    <table style="width: 100%;">
                        <tr>
                            <td>Sr. Citizen TIN:</td>
                            <td style="width: 200px; border-bottom: 1px solid gray;"></td>
                        </tr>
                        <tr>
                            <td>OSCA/PWD ID No:</td>
                            <td style="width: 200px; border-bottom: 1px solid gray;"></td>
                        </tr>
                        <tr>
                            <td>Senior Citizen / PWD discount</td>
                            <td style="width: 200px; border-bottom: 1px solid gray;"></td>
                        </tr>
                        <tr>
                            <td>Signature:</td>
                            <td style="width: 200px; border-bottom: 1px solid gray;"></td>
                        </tr>
                    </table>
                </td>
            </tr>

            <tr>
                <td colspan="6">&nbsp;</td>
            </tr>

            <tr>
                <td style="width: 200px;">Amount received in words:</td>
                <td colspan="5">
                    {{ $payload['header']['formatted_spelled_amount'] }}
                </td>
            </tr>

            <tr>
                <td colspan="6" class="border-b">&nbsp;</td>
            </tr>

            <tr class="text-center">
                <td class="bold">FORM OF PAYMENT</td>
                <td>Cash </td>
                <td>Check</td>
                <td>Check Number:</td>
                <td>Check Date</td>
                <td>Bank</td>
            </tr>
            <tr class="text-center border-b">
                <td></td>
                <td>{{ $payload['form_of_payment']['cash'] }}</td>
                <td>{{ $payload['form_of_payment']['check'] }}</td>
                <td>{{ $payload['form_of_payment']['check_number'] }}</td>
                <td>{{ $payload['form_of_payment']['check_date'] }}</td>
                <td>{{ $payload['form_of_payment']['bank'] }}</td>
            </tr>
            <tr>
                <td class="text-right" style="width: 200px;">RECEIVED BY:</td>
                <td colspan="5">{{ $payload['header']['collector']['name'] }}</td>
            </tr>
            <tr class="border-b">
                <td class="text-right" style="width: 200px;">DATE & TIME:</td>
                <td colspan="5">{{ $payload['header']['formatted_date_time'] }}</td>
            </tr>

            <tr>
                <td colspan="6">&nbsp;</td>
            </tr>

            <tr>
                <td colspan="6" class="text-center">**Payments other than Cash shall be recognized only upon actual receipt of the amount paid.</td>
            </tr>

            <tr>
                <td colspan="6">&nbsp;</td>
            </tr>

            <tr>
                <td colspan="6"  class="text-center">THIS SERVES AS YOUR OFFICIAL RECEIPT</td>
            </tr>
            <tr>
                <td colspan="6"  class="text-center">THANK YOU</td>
            </tr>
            <tr>
                <td colspan="6">&nbsp;</td>
            </tr>

            <tr>
                <td colspan="6"  class="text-center">Accreditation No: XXX-XXXXXXXXX-XXXXXXXXXXX</td>
            </tr>
            <tr>
                <td colspan="6"  class="text-center">Date Issued: 09/25/2020 Valid Until: XX/XX/XXXX</td>
            </tr>
            <tr>
                <td colspan="6"  class="text-center">BIR Permit To Use CAS Number: XXXX-XXX-XXXXX-XXX</td>
            </tr>
            <tr>
                <td colspan="6"  class="text-center">Date Issued: 09/25/2020 Valid Until: XX/XX/XXXX</td>
            </tr>
            <tr>
                <td colspan="6"  class="text-center">Range of Serial Nos: E00000001 - E99999999</td>
            </tr>

            <tr>
                <td colspan="6">&nbsp;</td>
            </tr>
            <tr>
                <td colspan="6"  class="text-center bold">"THIS OFFICIAL RECEIPT SHALL BE VALID FOR FIVE (5) YEARS FROM THE DATE OF THE PERMIT TO USE"</td>
            </tr>

        </tbody>
    </table>
</x-mail-base>
