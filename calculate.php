<?php
  
// Include the header:

include_once('includes/header.php');

// Retrieve the values of the text boxes from the form and assign them to PHP variables.

$firstName = trim($_POST['firstName']);
$lastName = trim($_POST['lastName']);
$hourlyRate = $_POST['hourlyRate'];
$numHoursWeek = $_POST['hoursWeek'];

/*
—————————————————————————————————————————————
Calculate Gross Income (Two Week Pay Period):
—————————————————————————————————————————————

Given the hourly rate and the number of hours worked per week, calculate the gross income for 
a 2-week period. If the number of hours worked per week exceeds 40, the employee is paid 1.5x 
their hourly rate for every hour over 40 hours. Remember, the text box in the form asks for 
the number of hours that an employee has worked for a SINGLE week, not two. This means, in 
either case (overtime or not), we must double our results to get the correct gross income for 
TWO weeks.
*/

$grossIncomeTwoWeeks = 0;

// If the employee has worked over 40 hours, apply overtime pay:

if ($numHoursWeek > 40.0)
{
  $grossIncomeTwoWeeks = 2 * ((($numHoursWeek - 40.0) * (1.5 * $hourlyRate)) + (40.0 * $hourlyRate));
}

// Otherwise, just multiply number of hours worked by the hourly rate.

else
{
  $grossIncomeTwoWeeks = 2 * ($numHoursWeek * $hourlyRate);
} 

/*
——————————————————————————————————————————
Calculate Gross Income (Projected Annual):
——————————————————————————————————————————

Federal tax and state taxes are derived as a percentage of the projected annual gross 
income, which itself is extrapolated from the earlier gross income calculated for a 
2-week period. Since we know what the gross income is for two weeks, simply multiply 
this value by the number of 2-week periods in a year to get the projected ANNUAL gross 
income (365.25 days in a year / 14 days per two-week period = About 26 pay periods).
*/

$grossIncomeAnnualProjected = $grossIncomeTwoWeeks * (365.25 / 14.0);
    
/*
————————————
Federal Tax:
————————————

Federal tax rates are applied according to the following (taken from the handout):
- 24% if annual gross income is greater than $82,500.
- 22% if annual gross income is between $38,701 and $82,500.
- 12% if annual gross income is between $9,526 and $38,700.
- 10% if annual gross income is $9,525 or less.
*/

$federalTax = 0;
    
if ($grossIncomeAnnualProjected > 82500)
{
  $federalTax = 0.24 * $grossIncomeTwoWeeks;
}

else if ($grossIncomeAnnualProjected >= 38701)
{
  $federalTax = 0.22 * $grossIncomeTwoWeeks;
}

else if ($grossIncomeAnnualProjected >= 9526)
{
  $federalTax = 0.12 * $grossIncomeTwoWeeks;
}

else
{
  $federalTax = 0.10 * $grossIncomeTwoWeeks;
}

/*
——————————
State Tax:
——————————

State tax rates are as follows (again, from the handout):
- 5% if annual gross income is greater than $25,000.
- 4% if annual gross income is between $10,000 and 25,000.
- 3% if annual gross income is less than $10,000.
*/

$stateTax = 0;

if ($grossIncomeAnnualProjected > 25000)
{
  $stateTax = 0.05 * $grossIncomeTwoWeeks;
}

else if ($grossIncomeAnnualProjected >= 10000)
{
  $stateTax = 0.04 * $grossIncomeTwoWeeks;
}

else
{
  $stateTax = 0.03 * $grossIncomeTwoWeeks;
}

/*
———————————————————————
Social Security - 6.2%:
———————————————————————
*/

$socialSecurityTax = 0.062 * $grossIncomeTwoWeeks;

/*
—————————————————————
Medicare Tax - 1.45%:
—————————————————————
*/

$medicareTax = 0.0145 * $grossIncomeTwoWeeks;

/*
————————————————————————————————————————————
Net Pay (Gross Income Minus All Deductions):
————————————————————————————————————————————
*/

$netPay = $grossIncomeTwoWeeks - ($federalTax + $stateTax + $socialSecurityTax + $medicareTax);

?>

<!-- 
NOTE: Most of the HTML below is identical to the HTML for index.php, albeit with some of the 
animations removed. The main difference is the replacement of the #greetingMessage with the 
results of our paycheck calculator in the #outputSection. 
-->

<main class="row py-3">

  <div class="container align-self-center">

    <div class="row">

      <!-- Input Section -->

      <section class="col-lg-6 bg-light">
      
        <form action="calculate.php" method="post" class="p-5 h-100">

          <!-- Input Heading ("Employee Information") -->

          <h2 class="h4 pb-3 mb-4 heading text-center border-bottom">Employee Information</h2>

          <!-- Input Body (Form Fields) -->

          <div id="inputBody">

            <!-- Employee First and Last Name -->

            <div class="form-group row">
              <div class="col-md-6 mb-4 mb-lg-0">
                <label for="firstName">First Name:</label>
                <input type="text" id="firstName" name="firstName" class="form-control" required>
              </div>
              <div class="col-md-6">
                <label for="lastName">Last Name:</label>
                <input type="text" id="lastName" name="lastName" class="form-control" required>
              </div>
            </div>

            <!-- Employee Hourly Rate -->

            <div class="form-group row">
              <div class="col-md-12">
                <label for="hourlyRate">Hourly Rate ($):</label>
                <input type="text" id="hourlyRate" name="hourlyRate" class="form-control forceNumeric" required>
              </div>
            </div>

            <!-- Employee Hours Worked Per Week -->

            <div class="form-group row">
              <div class="col-md-12">
                <label for="hoursWeek">Hours Worked Per Week:</label>
                <input type="text" id="hoursWeek" name="hoursWeek" class="form-control forceNumeric" required>
              </div>
            </div>

            <!-- Submit Button -->

            <div class="form-group row mb-0 mt-3">
              <div class="col-md-12">
                <input type="submit" class="btn btn-block btn-primary text-white py-3 px-5" value="Submit" >
              </div>
            </div>

          </div>
    
        </form>
      
      </section>

      <!-- Output Section -->
      
      <section class="col-lg-6 bg-primary text-white">
        
        <div class="p-5 h-100">

            <?php

            /*
            —————————————————————————————
            Injecting HTML code with PHP:
            —————————————————————————————

            Now that we have calculated the values for our PHP variables, it's time to 
            turn our attention to how this information should be displayed to the user. 
            This mostly involves the use of PHP's echo command to inject HTML code, but 
            we'll also be using htmlspecialchars() and number_format() for formatting
            purposes.
            */

            // Output Heading

            echo 
            "<h2 class='h4 pb-3 mb-4 heading text-center border-bottom'>".
                htmlspecialchars($firstName)." ".htmlspecialchars($lastName)."'s Paycheck
            </h2>";

            // Output Body

            echo
            "<div id='outputBodyRow' class='row'>

                <div id='outputBodyCol' class='col'>

                    <div class='row mb-3'>
                        <div class='col-6 align-self-center'>
                            Gross Income:
                        </div>
                        <div class='col-6 text-right align-self-center'>
                            $".number_format($grossIncomeTwoWeeks, 2)."
                        </div>
                    </div>

                    <div class='row mb-3'>
                        <div class='col-6 align-self-center'>
                            Federal Tax:
                        </div>
                        <div class='col-6 text-right align-self-center'>
                            – $".number_format($federalTax, 2)."
                        </div>
                    </div>

                    <div class='row mb-3'>
                        <div class='col-6 align-self-center'>
                            State Tax:
                        </div>
                        <div class='col-6 text-right align-self-center'>
                            – $".number_format($stateTax, 2)."
                        </div>
                    </div>

                    <div class='row mb-3'>
                        <div class='col-6 align-self-center'>
                            Social Security Tax:
                        </div>
                        <div class='col-6 text-right align-self-center'>
                            – $".number_format($socialSecurityTax, 2)."
                        </div>
                    </div>

                    <div class='row mb-3'>
                        <div class='col-6 align-self-center'>
                            Medicare Tax:
                        </div>
                        <div class='col-6 text-right align-self-center'>
                            – $".number_format($medicareTax, 2)."
                        </div>
                    </div>

                    <div class='row mx-0'>
                        <div class='border-bottom w-100'></div>
                        <div class='border-top w-100 mb-3'></div>
                    </div>
                    
                    <div class='row mb-3'>
                        <div class='col-6 align-self-center'>
                            Net Pay:
                        </div>
                        <div class='col-6 text-right align-self-center'>
                            $".number_format($netPay, 2)."
                        </div>
                    </div>

                </div>

            </div>";
            ?>

        </div>

      </section>

    </div>

  </div>

</main>

<?php
  include_once('includes/footer.php');
?>