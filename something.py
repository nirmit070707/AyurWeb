from flask import Flask, request, jsonify
from flask_cors import CORS
import joblib
import numpy as np

app = Flask(__name__)
CORS(app)  # Allow frontend access

# Load your trained model
try:
    model = joblib.load("prakriti_model.joblib")
    print("Model loaded successfully!")
except Exception as e:
    print(f"Warning: Failed to load model: {e}")
    model = None

# Route to handle prediction
@app.route("/predict", methods=["POST"])
def predict():
    if model is None:
        return jsonify({"error": "Model not loaded"}), 500
        
    data = request.get_json()
    answers = data.get("answers")

    if not answers or len(answers) != 10:
        return jsonify({"error": "Exactly 10 answers (A/B/C) required."}), 400

    # Map A/B/C to counts
    try:
        count_a = answers.count('A')
        count_b = answers.count('B')
        count_c = answers.count('C')
        total = len(answers)

        # Convert to percentages
        percent_a = (count_a / total) * 100
        percent_b = (count_b / total) * 100
        percent_c = (count_c / total) * 100

        input_vector = np.array([[percent_a, percent_b, percent_c]])

        prediction = model.predict(input_vector)[0]
        
        # Also return the percentages for display
        return jsonify({
            "prediction": prediction,
             "percentages": {
                "vata": percent_a,
                "pitta": percent_b,
                "kapha": percent_c
            }
        })
    except Exception as e:
        return jsonify({"error": f"Prediction failed: {str(e)}"}), 500

# Health check endpoint
@app.route("/health", methods=["GET"])
def health():
    return jsonify({"status": "Server is running", "model_loaded": model is not None})

if __name__ == "__main__":
    print("Starting Flask server...")
    print("Make sure your prakriti_model.joblib file is in the same directory")
    app.run(debug=True, port=5000)