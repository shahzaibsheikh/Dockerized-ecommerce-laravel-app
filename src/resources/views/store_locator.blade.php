<!------ Store Locator ------->
<section class="bg-light py-5">
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3402.5513466616244!2d74.30043917469473!3d31.48152574906182!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x391903f08ebc7e8b%3A0x47e934f4cd34790!2sFAST%20NUCES%20Lahore!5e0!3m2!1sen!2s!4v1731932103575!5m2!1sen!2s" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
            </div>
            <div class="col-md-6 float-end">
                <h3>{{ __( app()->getlocale().'.1') }}</h3>
                <hr>
                <table class="table table-borderless table-condensed">
                    <tbody>
                    <tr>
                        <td style="width: 16.66%"><i class="fa fa-whatsapp" aria-hidden="true"></i>&nbsp;Mobile</td>
                        <td style="width: 2.66%">:</td>
                        <td><a href="http://wa.me/8849004643" target="_blank" style="color: black;">+92-12345678</a>
                        </td>
                    </tr>
                    <tr>
                        <td><i class="fa fa-envelope" aria-hidden="true"></i>&nbsp;Email</td>
                        <td>:</td>
                        <td><a href="mailto:info@learnvern.com"
                               style="color: black;">info@test.com</a></td>
                    </tr>
                    <tr>
                        <td><i class="fa fa-map-marker" aria-hidden="true"></i>&nbsp;Address</td>
                        <td>:</td>
                        <td>{{ __( app()->getlocale().'.1') }}, <br>
                            LHR, <br>
                           Pakistan <br>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</section>
