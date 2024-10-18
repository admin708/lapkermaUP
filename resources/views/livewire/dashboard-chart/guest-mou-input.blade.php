<div class="container">
    <h1>MoU Form</h1>
    <form method="POST" enctype="multipart/form-data">
        @csrf

        <div>
            <label for="university_name">University / Company Name:</label>
            <input type="text" id="university_name" name="university_name" required>
        </div>

        <div>
            <label for="country_of_origin">Country of Origin (Negara Asal):</label>
            <input type="text" id="country_of_origin" name="country_of_origin" required>
        </div>

        <div>
            <label for="scope">Scope:</label>
            <textarea id="scope" name="scope" required></textarea>
            <p>• Research collaboration in the areas of mutual interest;</p>
            <p>• Exchange of academic materials which are made available by both parties;</p>
            <p>• Exchange of scholars;</p>
            <p>• Student mobility;</p>
            <p>• Cooperative seminars, workshops, and other academic activities.</p>
        </div>

        <div>
            <label for="signing_date">Planned MoU Active Date / Signing Date:</label>
            <input type="date" id="signing_date" name="signing_date" required>
        </div>

        <div>
            <label for="duration_years">Planned MoU Duration (in years):</label>
            <input type="number" id="duration_years" name="duration_years" required>
        </div>

        <div>
            <h3>Notices / Communication / Person in Charge (PIC)</h3>
            <label for="pic_name">Nama:</label>
            <input type="text" id="pic_name" name="pic_name" required>

            <label for="pic_designation">Designation / Position:</label>
            <input type="text" id="pic_designation" name="pic_designation" required>

            <label for="pic_address">Address:</label>
            <input type="text" id="pic_address" name="pic_address" required>

            <label for="pic_email">Email:</label>
            <input type="email" id="pic_email" name="pic_email" required>

            <label for="pic_phone">Telephone Number:</label>
            <input type="text" id="pic_phone" name="pic_phone" required>
        </div>

        <div>
            <h3>Signing Authorized Representative</h3>
            <label for="rep_name">Nama:</label>
            <input type="text" id="rep_name" name="rep_name" required>

            <label for="rep_designation">Designation / Position:</label>
            <input type="text" id="rep_designation" name="rep_designation" required>
        </div>

        <div>
            <label for="logo">University Logo (PNG):</label>
            <input type="file" id="logo" name="logo" accept="image/png" required>
        </div>

        <button type="submit">Submit</button>
    </form>
</div>
