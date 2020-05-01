# php-tax-invoice
PHP Library to Compute GST Tax and Print PDF Invoice

Overview
===============
This codebase helps in computing tax and creating invoice PDF

PHP Setup
===============
1) In the php.ini, to enable the "mbstring" PHP extension
```
extension_dir = "ext"
extension=mbstring
```

2) This code uses dompdf library (https://github.com/dompdf/dompdf)
You must copy and unzip this library under the "dompdf" folder. See the Download and install section.

NOTE: This is under LGPL License. This code is only to be used for demonstration purposes
https://github.com/dompdf/dompdf/blob/master/LICENSE.LGPL

Key Files
===============
**order.php:** Class representing an Order
**orderitem.php:** Class representing an OrderItem (order line item) It also stores computed tax values
**gst.php:** Provides method to comput GST and store in respective OrderItem. The method to invoke is computeGST()
**invoice-pdf.php:** Provides method to print invoice PDF. The method to invoke is createInvoicePdf();

Key Pointers on GST Computation (gst.php)
============================================
For logic of tax computation, please read
https://www.axisbank.com/progress-with-us/money-matters/what-is-cgst-sgst-utgst-igst


The code assumes that **toState** and **fromState** are provided as uppercase state abbreviations. E.g. KA (for Karnataka), AN (for Andaman)
Following states are assumed to be Union Territories


AN, DN, CH, LD, DD

For all state codes, please se
https://kb.bullseyelocations.com/support/solutions/articles/5000695302-india-state-codes

Following GST rates are hard-coded as an example. You MUST modify to code to load tax rates against HSN code from a DB.
```
$hsnRateMap = array(); 
$hsnRateMap["hsn1"] = 5; 
$hsnRateMap["hsn2"] = 18; 
$hsnRateMap["hsn3"] = 5; 
$hsnRateMap["hsn4"] = 18; 
```
If no matching HSN is found, then the default rate of 18% is used.

Testing
============================================
Test cases are provided in 
**test-gst.php:** Prints the computed tax values on the console.
**test-invoice-pdf.php:** The PDF output is written into the "pdf" folder.

You can simply run the test cases (and hence the code) as
```
php test-gst.php
php test-invoice-gst.php
```