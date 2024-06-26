<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BMR Calculator</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500&display=swap" rel="stylesheet">
    <style>
/* Global styles */
body {
    font-family: 'Roboto', sans-serif;
    margin: 0;
    padding: 0;
    background-image: url('background.jpg');
    background-size: cover;
    background-repeat: no-repeat;
    background-attachment: fixed;
    color: #333;
}

.container {
    max-width: 800px;
    margin: 50px auto;
    padding: 20px;
    background-color: rgba(255, 255, 255, 0.9);
    border-radius: 10px;
    box-shadow: 0 0 20px rgba(0, 0, 0, 0.2);
}

h2 {
    text-align: center;
    color: #333;
    margin-bottom: 30px;
    font-weight: 500;
}

.form-group {
    margin-bottom: 20px;
}

label {
    display: block;
    margin-bottom: 5px;
}

input[type="number"],
select {
    width: calc(100% - 22px);
    padding: 10px;
    border: 1px solid #ccc;
    border-radius: 5px;
    font-size: 16px;
}

button {
    width: 100%;
    padding: 10px 15px;
    background-color: #28a745;
    color: white;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    font-size: 16px;
    transition: background-color 0.3s;
}

button:hover {
    background-color: #218838;
}

.result {
    margin-top: 20px;
    padding: 15px;
    background-color: #f4f4f4;
    border: 1px solid #ccc;
    border-radius: 8px;
    text-align: center;
}

.result h3 {
    margin-top: 0;
    color: #333;
    font-size: 22px;
}

.result p {
    color: #666;
    font-size: 16px;
}

.back-btn {
    display: block;
    margin-top: 20px;
    text-align: center;
    font-size: 16px;
    color: #333;
    text-decoration: none;
}

.back-btn:hover {
    text-decoration: underline;
}

    </style>
</head>

<body>
    <div class="container">
        <h2>BMR Calculator</h2>
        <form id="bmrForm">
            <label for="age">Age:</label>
            <input type="number" id="age" name="age" required>

            <label for="gender">Gender:</label>
            <select id="gender" name="gender" required>
                <option value="male">Male</option>
                <option value="female">Female</option>
            </select>

            <label for="weight">Weight (kg):</label>
            <input type="number" id="weight" name="weight" required>

            <label for="height">Height (cm):</label>
            <input type="number" id="height" name="height" required>

            <label for="bodyFat">Body Fat Percentage (for Katch-McArdle and Cunningham):</label>
            <input type="number" id="bodyFat" name="bodyFat" step="0.1" required>

            <label for="activity">Activity Level:</label>
            <select id="activity" name="activity" required>
                <option value="sedentary">Sedentary (little or no exercise)</option>
                <option value="light">Lightly active (light exercise/sports 1-3 days/week)</option>
                <option value="moderate">Moderately active (moderate exercise/sports 3-5 days/week)</option>
                <option value="very">Very active (hard exercise/sports 6-7 days a week)</option>
                <option value="extra">Extra active (very hard exercise/sports & physical job)</option>
            </select>

            <button type="button" onclick="calculateBMR()">Calculate BMR</button>
        </form>

        <div id="result" class="result"></div>

        <!-- Back button to return to customer dashboard -->
        <a href="dashboard_customer.php" class="back-btn">Back to Dashboard</a>
    </div>

    <script>
        function calculateBMR() {
            const age = document.getElementById('age').value;
            const gender = document.getElementById('gender').value;
            const weight = document.getElementById('weight').value;
            const height = document.getElementById('height').value;
            const bodyFat = document.getElementById('bodyFat').value;
            const activity = document.getElementById('activity').value;

            let bmrHarrisBenedict;
            let bmrMifflinStJeor;
            let bmrKatchMcArdle;
            let bmrSchofield;
            let bmrCunningham;
            let tef;
            let tdee;

            // Harris-Benedict Equation
            if (gender === 'male') {
                bmrHarrisBenedict = 88.362 + (13.397 * weight) + (4.799 * height) - (5.677 * age);
            } else {
                bmrHarrisBenedict = 447.593 + (9.247 * weight) + (3.098 * height) - (4.330 * age);
            }

            // Mifflin-St Jeor Equation
            if (gender === 'male') {
                bmrMifflinStJeor = (10 * weight) + (6.25 * height) - (5 * age) + 5;
            } else {
                bmrMifflinStJeor = (10 * weight) + (6.25 * height) - (5 * age) - 161;
            }

            // Katch-McArdle Equation
            bmrKatchMcArdle = 370 + (21.6 * (weight * (1 - (bodyFat / 100))));

            // Schofield Equation
            if (gender === 'male') {
                bmrSchofield = (0.0484 * weight + 3.653 * height - 0.161 * age) * 1000;
            } else {
                bmrSchofield = (0.0342 * weight + 3.5377 * height - 0.087 * age) * 1000;
            }

            // Cunningham Equation
            bmrCunningham = 500 + 22 * (weight * (1 - (bodyFat / 100)));

            // Thermic Effect of Food (TEF)
            tef = 0.1 * bmrMifflinStJeor;

            // Physical Activity Level (PAL) based on Mifflin-St Jeor BMR
            switch (activity) {
                case 'sedentary':
                    tdee = bmrMifflinStJeor * 1.2;
                    break;
                case 'light':
                    tdee = bmrMifflinStJeor * 1.375;
                    break;
                case 'moderate':
                    tdee = bmrMifflinStJeor * 1.55;
                    break;
                case 'very':
                    tdee = bmrMifflinStJeor * 1.725;
                    break;
                case 'extra':
                    tdee = bmrMifflinStJeor * 1.9;
                    break;
            }

            const resultDiv = document.getElementById('result');
            resultDiv.innerHTML = `
                <h3>Basal Metabolic Rate (BMR)</h3>
                <p>Harris-Benedict: ${bmrHarrisBenedict.toFixed(2)} calories/day</p>
                <p>Mifflin-St Jeor: ${bmrMifflinStJeor.toFixed(2)} calories/day</p>
                <p>Katch-McArdle: ${bmrKatchMcArdle.toFixed(2)} calories/day</p>
                <p>Schofield: ${bmrSchofield.toFixed(2)} calories/day</p>
                <p>Cunningham: ${bmrCunningham.toFixed(2)} calories/day</p>
                <h3>Thermic Effect of Food (TEF)</h3>
                <p>TEF: ${tef.toFixed(2)} calories/day</p>
                <h3>Total Daily Energy Expenditure (TDEE)</h3>
                <p>TDEE: ${tdee.toFixed(2)} calories/day</p>
            `;

            let recommendation = '';
            if (bmrMifflinStJeor < 1500) {
                recommendation = 'Your BMR is quite low. Consider consulting with a healthcare provider for personalized advice.';
            } else if (bmrMifflinStJeor >=1500 && bmrMifflinStJeor <= 2500) {
                recommendation = 'Your BMR is within the average range. Maintain a balanced diet and regular exercise.';
            } else {
                recommendation = 'Your BMR is high. Ensure you are eating enough to support your metabolic needs.';
            }

            resultDiv.innerHTML += `<p>${recommendation}</p>`;

            // Scroll to the result section for better visibility
            resultDiv.scrollIntoView({ behavior: 'smooth' });
        }
    </script>
</body>

</html>

