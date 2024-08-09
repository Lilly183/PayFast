<?php
  include_once('includes/header.php');
?>

    <main class="row py-3">

      <div class="container align-self-center">

        <div class="row" data-aos="fade-up" data-aos-delay="50">
        
          <!-- Input Section -->

          <section class="col-lg-6 bg-light" data-aos="fade-up" data-aos-delay="50">
          
            <form action="calculate.php" method="post" class="p-5 h-100">
              
              <!-- Input Heading ("Employee Information") -->

              <h2 class="h4 pb-3 mb-4 heading text-center border-bottom">Employee Information</h2>

              <!-- Input Body (Form Fields) -->

              <div id="inputBody">

                <!-- Employee First and Last Name -->

                <div class="form-group row">
                  <div class="col-md-6 mb-4 mb-lg-0">
                    <label for="firstName">First Name:</label>
                    <input type="text" id="firstName" name="firstName" class="form-control" placeholder="John" required>
                  </div>
                  <div class="col-md-6">
                    <label for="lastName">Last Name:</label>
                    <input type="text" id="lastName" name="lastName" class="form-control" placeholder="Doe" required>
                  </div>
                </div>

                <!-- Employee Hourly Rate -->
  
                <div class="form-group row">
                  <div class="col-md-12">
                    <label for="hourlyRate">Hourly Rate ($):</label>
                    <input type="text" id="hourlyRate" name="hourlyRate" class="form-control forceNumeric" placeholder="15" required>
                  </div>
                </div>

                <!-- Employee Hours Worked Per Week -->
  
                <div class="form-group row">
                  <div class="col-md-12">
                    <label for="hoursWeek">Hours Worked Per Week:</label>
                    <input type="text" id="hoursWeek" name="hoursWeek" class="form-control forceNumeric" placeholder="40" required>
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
          
          <section class="col-lg-6 bg-primary text-white" data-aos="fade-up" data-aos-delay="50">
            
            <div class="p-5 h-100">

              <div id="greetingMessageRow" class="row h-100">
                
                <div id="greetingMessageCol" class="col my-auto">

                  <!-- Greeting Message -->

                  <div id="greetingMessage">

                    <!-- "Welcome" Paragraph -->

                    <p class="mb-4">
                      Welcome to PayFAST – the quick and easy way to pay your employees! Getting 
                      started is as simple as 1, 2, 3:
                    </p>

                    <!-- "Instructions" List -->

                    <ol>
                      <li class="mb-3">Enter your employee's name</li>
                      <li class="mb-3">Enter the rate you pay your employee per hour</li>
                      <li class="mb-3">Enter the number of hours your employee works per week</li>
                    </ol>

                    <!-- "Submit" Paragraph -->

                    <p class="mt-4">
                    Click the "Submit" button when done! Our online calculator generates a paystub 
                    for a two-week pay period and features a complete breakdown of all deductions. 
                    Try it now for free!
                    </p>
                    
                  </div>

                </div>
              
              </div>

            </div>

          </section>

        </div>

      </div>

    </main>

<?php
  include_once('includes/footer.php');
?>