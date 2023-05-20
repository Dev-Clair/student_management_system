<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link
      href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css"
      rel="stylesheet"
    />
    <title>Student Management System</title>
  </head>
  <body>
    <div class="container my-5">
      <form action="main.php" method="POST">
        <div class="mb-3">
          <label for="name" class="form-label"><strong>Name:</strong></label>
          <input
            type="text"
            class="form-control"
            id="name"
            name="name"
            placeholder="Enter Student's First and Last Names"
          />
        </div>
        <div class="mb-3">
          <label for="registration" class="form-label"
            ><strong>Registration No.:</strong></label
          >
          <input
            type="text"
            class="form-control"
            id="registration"
            name="regNo"
            placeholder="Reg. No."
          />
        </div>
        <div>
          <label for="grade" class="form-label"><strong>Grade:</strong></label>
          <input
            type="text"
            class="form-control"
            id="grade"
            name="grade"
            placeholder="Enter Grade"
          />
        </div>
        <div id="gradehelpinfo" class="form-text mb-3">
          Grade must be positive integers between 0-10; it cannot be negative
          numbers or contain characters, or emoji.
        </div>
        <div class="mb-3">
          <label for="classroom" class="form-label"
            ><strong>Class:</strong></label
          >
          <select class="form-select" id="classroom" name="class">
            <option selected disabled>Click to Select</option>
            <option value="frontend">Frontend</option>
            <option value="backend">Backend</option>
          </select>
        </div>
        <button type="submit" class="btn btn-primary" name="submit">
          Submit
        </button>
      </form>
    </div>
  </body>
</html>
