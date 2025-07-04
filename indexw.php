<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <title>Ayurveda Dosha Quiz</title>
    <style>
      /* Modern Font and Base Styles */
      @import url("https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap");

      :root {
        --primary-purple: #6b5b8d;
        --light-purple: #8a7ba8;
        --sage-purple: #9d8fb5;
        --cream: #f8f6f0;
        --soft-beige: #f2efe8;
        --earth-brown: #8b6914;
        --deep-blue: #2c5f6f;
        --fire-orange: #d4693b;
        --space-purple: #6b5b8d;
        --water-blue: #4a90a4;
        --air-cyan: #7fb3b3;
        --gold: #c9a876;
        --text-dark: #2c3e50;
        --text-light: #ffffff;
        --warm-terracotta: #d4693b;
        --soft-lavender: #b8a9d9;
      }

      body {
        font-family: "Poppins", sans-serif;
        margin: 0;
        padding: 0;
        min-height: 100vh;
        color: var(--text-dark);
        position: relative;
        line-height: 1.6;
        background: linear-gradient(
          135deg,
          var(--cream) 0%,
          var(--soft-beige) 100%
        );
        overflow-x: hidden;
      }

      /* Animated Background Elements - Five Tattvas */
      .background-elements {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        pointer-events: none;
        z-index: -1;
        overflow: hidden;
      }

      .tattva-element {
        position: absolute;
        opacity: 0.08;
        animation-timing-function: ease-in-out;
        animation-iteration-count: infinite;
        animation-direction: alternate;
      }

      /* Air Element - Floating circles */
      .air-element {
        width: 50px;
        height: 50px;
        border-radius: 50%;
        background: radial-gradient(circle, var(--air-cyan), transparent);
        animation: float 8s infinite;
      }

      .air-1 {
        top: 15%;
        left: 25%;
        animation-delay: 0s;
      }
      .air-2 {
        top: 65%;
        right: 20%;
        animation-delay: 2s;
      }
      .air-3 {
        top: 45%;
        left: 75%;
        animation-delay: 4s;
      }

      /* Water Element - Flowing waves */
      .water-element {
        width: 80px;
        height: 15px;
        background: linear-gradient(
          90deg,
          transparent,
          var(--water-blue),
          transparent
        );
        border-radius: 50px;
        animation: wave 7s infinite;
      }

      .water-1 {
        top: 30%;
        left: -40px;
        animation-delay: 0s;
      }
      .water-2 {
        top: 60%;
        right: -40px;
        animation-delay: 3s;
      }

      /* Fire Element - Flickering triangles */
      .fire-element {
        width: 0;
        height: 0;
        border-left: 12px solid transparent;
        border-right: 12px solid transparent;
        border-bottom: 24px solid var(--fire-orange);
        animation: flicker 4s infinite;
      }

      .fire-1 {
        top: 25%;
        right: 30%;
        animation-delay: 0s;
      }
      .fire-2 {
        top: 70%;
        left: 15%;
        animation-delay: 1s;
      }

      /* Space Element - Ethereal dots */
      .space-element {
        width: 6px;
        height: 6px;
        background: var(--space-purple);
        border-radius: 50%;
        animation: twinkle 3s infinite;
      }

      .space-1 {
        top: 20%;
        left: 55%;
        animation-delay: 0s;
      }
      .space-2 {
        top: 50%;
        left: 35%;
        animation-delay: 1s;
      }
      .space-3 {
        top: 75%;
        right: 25%;
        animation-delay: 2s;
      }

      @keyframes float {
        0%,
        100% {
          transform: translateY(0px) rotate(0deg);
        }
        50% {
          transform: translateY(-15px) rotate(180deg);
        }
      }

      @keyframes wave {
        0% {
          transform: translateX(-80px) scaleX(0.5);
        }
        50% {
          transform: translateX(50vw) scaleX(1);
        }
        100% {
          transform: translateX(calc(100vw + 80px)) scaleX(0.5);
        }
      }

      @keyframes flicker {
        0%,
        100% {
          opacity: 0.08;
          filter: brightness(1);
        }
        25% {
          opacity: 0.15;
          filter: brightness(1.2);
        }
        50% {
          opacity: 0.1;
          filter: brightness(0.8);
        }
        75% {
          opacity: 0.18;
          filter: brightness(1.1);
        }
      }

      @keyframes twinkle {
        0%,
        100% {
          opacity: 0.08;
          transform: scale(1);
        }
        50% {
          opacity: 0.2;
          transform: scale(1.3);
        }
      }

      /* Welcome Container */
      #instructionContainer {
        background: rgba(255, 255, 255, 0.95);
        border-radius: 25px;
        padding: 50px;
        width: 85%;
        max-width: 900px;
        margin: 5vh auto;
        box-shadow: 0 20px 40px rgba(107, 91, 141, 0.15);
        backdrop-filter: blur(10px);
        border: 1px solid rgba(255, 255, 255, 0.3);
        animation: fadeIn 0.8s ease-out;
        position: relative;
      }

      #instructionContainer::before {
        content: "";
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        border-radius: 25px;
        padding: 2px;
        background: linear-gradient(
          135deg,
          var(--primary-purple),
          var(--gold),
          var(--fire-orange)
        );
        mask: linear-gradient(#fff 0 0) content-box, linear-gradient(#fff 0 0);
        mask-composite: exclude;
        opacity: 0.6;
      }

      @keyframes fadeIn {
        from {
          opacity: 0;
          transform: translateY(30px);
        }
        to {
          opacity: 1;
          transform: translateY(0);
        }
      }

      /* Header Styles */
      .welcome-header {
        text-align: center;
        margin-bottom: 30px;
        padding-bottom: 20px;
        position: relative;
      }

      .welcome-header::after {
        content: "";
        position: absolute;
        bottom: 0;
        left: 50%;
        transform: translateX(-50%);
        width: 120px;
        height: 4px;
        background: linear-gradient(
          90deg,
          var(--primary-purple),
          var(--gold),
          var(--fire-orange)
        );
        border-radius: 2px;
      }

      .welcome-header h1 {
        color: var(--text-dark);
        font-size: 3rem;
        margin-bottom: 15px;
        font-weight: 700;
        letter-spacing: 1px;
        text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.1);
        background: linear-gradient(
          135deg,
          var(--primary-purple),
          var(--fire-orange)
        );
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
      }

      .welcome-header p {
        font-size: 1.3rem;
        color: var(--text-dark);
        margin-top: 15px;
        font-weight: 400;
        opacity: 0.8;
      }

      /* Decorative Elements */
      .ayurveda-icon {
        font-size: 4rem;
        margin-bottom: 20px;
        background: linear-gradient(135deg, var(--primary-purple), var(--gold));
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
        display: inline-block;
        animation: gentle-pulse 3s infinite;
      }

      @keyframes gentle-pulse {
        0%,
        100% {
          transform: scale(1);
        }
        50% {
          transform: scale(1.05);
        }
      }

      /* Instructions Section */
      .instructions-section {
        background: linear-gradient(
          135deg,
          rgba(184, 169, 217, 0.15),
          rgba(255, 248, 240, 0.8)
        );
        padding: 30px;
        border-radius: 20px;
        margin: 25px 0;
        border-left: 5px solid var(--primary-purple);
        box-shadow: 0 8px 25px rgba(107, 91, 141, 0.1);
      }

      .instructions-section h2 {
        color: var(--text-dark);
        margin-top: 0;
        font-size: 2rem;
        font-weight: 600;
        background: linear-gradient(
          135deg,
          var(--primary-purple),
          var(--fire-orange)
        );
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
      }

      .instructions-section ul {
        padding-left: 20px;
        font-size: 1.1rem;
      }

      .instructions-section li {
        margin-bottom: 15px;
        position: relative;
        padding-left: 30px;
        line-height: 1.7;
      }

      .instructions-section li:before {
        content: "✦";
        color: var(--primary-purple);
        font-size: 1.2rem;
        position: absolute;
        left: 0;
        top: 0;
      }

      /* Benefits Section */
      .dosha-benefits {
        margin: 30px 0;
        background: linear-gradient(
          135deg,
          rgba(212, 105, 59, 0.1),
          rgba(201, 168, 118, 0.1)
        );
        padding: 25px 30px;
        border-radius: 20px;
        border: 2px dashed var(--fire-orange);
        position: relative;
        overflow: hidden;
      }

      .dosha-benefits::before {
        content: "";
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: linear-gradient(
          45deg,
          transparent,
          rgba(107, 91, 141, 0.03),
          transparent
        );
        animation: shimmer 4s ease-in-out infinite;
      }

      @keyframes shimmer {
        0%,
        100% {
          transform: translateX(-100%);
        }
        50% {
          transform: translateX(100%);
        }
      }

      .dosha-benefits h3 {
        color: var(--text-dark);
        margin-top: 0;
        font-size: 1.6rem;
        font-weight: 600;
        background: linear-gradient(135deg, var(--fire-orange), var(--gold));
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
      }

      .dosha-benefits p {
        margin-bottom: 15px;
        font-size: 1.05rem;
        line-height: 1.7;
      }

      /* Disclaimer */
      .disclaimer {
        font-style: italic;
        background: rgba(255, 255, 255, 0.8);
        padding: 20px 25px;
        border-radius: 15px;
        margin-top: 25px;
        border-left: 4px solid var(--gold);
        font-size: 0.95rem;
        box-shadow: 0 4px 15px rgba(201, 168, 118, 0.2);
      }

      /* Start Button */
      .start-btn-container {
        text-align: center;
        margin-top: 40px;
      }

      .start-btn {
        padding: 18px 50px;
        background: linear-gradient(
          135deg,
          var(--primary-purple) 0%,
          var(--fire-orange) 100%
        );
        color: white;
        border: none;
        border-radius: 50px;
        cursor: pointer;
        font-size: 1.3rem;
        font-weight: 600;
        transition: all 0.4s ease;
        box-shadow: 0 8px 25px rgba(107, 91, 141, 0.3);
        text-transform: uppercase;
        letter-spacing: 1px;
        position: relative;
        overflow: hidden;
      }

      .start-btn::before {
        content: "";
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(
          90deg,
          transparent,
          rgba(255, 255, 255, 0.2),
          transparent
        );
        transition: left 0.5s ease;
      }

      .start-btn:hover::before {
        left: 100%;
      }

      .start-btn:hover {
        background: linear-gradient(
          135deg,
          var(--fire-orange) 0%,
          var(--primary-purple) 100%
        );
        transform: translateY(-3px);
        box-shadow: 0 12px 35px rgba(107, 91, 141, 0.4);
      }

      .start-btn:active {
        transform: translateY(-1px);
      }

      /* Quiz Container Styles */
      #quizContainer {
        display: none;
        background: rgba(255, 255, 255, 0.95);
        border-radius: 25px;
        padding: 40px;
        width: 85%;
        max-width: 900px;
        margin: 5vh auto;
        box-shadow: 0 20px 40px rgba(107, 91, 141, 0.2);
        animation: fadeIn 0.8s ease-out;
        position: relative;
      }

      #quizContainer::before {
        content: "";
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        border-radius: 25px;
        padding: 2px;
        background: linear-gradient(
          135deg,
          var(--primary-purple),
          var(--gold),
          var(--fire-orange)
        );
        mask: linear-gradient(#fff 0 0) content-box, linear-gradient(#fff 0 0);
        mask-composite: exclude;
        opacity: 0.6;
      }

      #quizContainer h1 {
        color: var(--text-dark);
        text-align: center;
        margin-bottom: 30px;
        font-size: 2.5rem;
        font-weight: 700;
        padding-bottom: 15px;
        background: linear-gradient(
          135deg,
          var(--primary-purple),
          var(--fire-orange)
        );
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
        position: relative;
      }

      #quizContainer h1::after {
        content: "";
        position: absolute;
        bottom: 0;
        left: 50%;
        transform: translateX(-50%);
        width: 100px;
        height: 4px;
        background: linear-gradient(
          90deg,
          var(--primary-purple),
          var(--fire-orange)
        );
        border-radius: 2px;
      }

      /* Enhanced Question Styling */
      .question {
        margin-bottom: 30px;
        padding: 25px;
        border-radius: 20px;
        background: linear-gradient(
          135deg,
          rgba(255, 255, 255, 0.9),
          rgba(248, 246, 240, 0.9)
        );
        box-shadow: 0 8px 25px rgba(107, 91, 141, 0.1);
        transition: all 0.4s ease;
        border: 1px solid rgba(107, 91, 141, 0.1);
      }

      .question:hover {
        transform: translateY(-5px);
        box-shadow: 0 15px 35px rgba(107, 91, 141, 0.15);
        border-color: var(--primary-purple);
      }

      .question p {
        margin-bottom: 20px;
        font-weight: 600;
        color: var(--text-dark);
        font-size: 1.3rem;
        background: linear-gradient(
          135deg,
          var(--primary-purple),
          var(--fire-orange)
        );
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
      }

      /* Improved Radio Options */
      .options {
        display: flex;
        flex-direction: column;
        gap: 15px;
      }

      .options label {
        display: flex;
        align-items: center;
        padding: 15px 20px;
        border-radius: 12px;
        transition: all 0.3s ease;
        cursor: pointer;
        background: rgba(255, 255, 255, 0.8);
        border: 2px solid transparent;
        position: relative;
        overflow: hidden;
      }

      .options label::before {
        content: "";
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(
          90deg,
          transparent,
          rgba(107, 91, 141, 0.1),
          transparent
        );
        transition: left 0.3s ease;
      }

      .options label:hover::before {
        left: 100%;
      }

      .options label:hover {
        background: linear-gradient(
          135deg,
          rgba(184, 169, 217, 0.15),
          rgba(255, 248, 240, 0.9)
        );
        border-color: var(--primary-purple);
        transform: translateX(5px);
      }

      .options input {
        margin-right: 15px;
        accent-color: var(--primary-purple);
        transform: scale(1.3);
      }

      .options input:checked + span {
        color: var(--primary-purple);
        font-weight: 600;
      }

      /* Submit Button */
      #quizForm button[type="button"] {
        padding: 18px 45px;
        background: linear-gradient(
          135deg,
          var(--primary-purple) 0%,
          var(--fire-orange) 100%
        );
        color: white;
        border: none;
        border-radius: 50px;
        cursor: pointer;
        font-size: 1.2rem;
        font-weight: 600;
        margin: 30px auto 0;
        display: block;
        transition: all 0.4s ease;
        box-shadow: 0 8px 25px rgba(107, 91, 141, 0.3);
        position: relative;
        overflow: hidden;
      }

      #quizForm button[type="button"]::after {
        content: "";
        position: absolute;
        top: 50%;
        left: 50%;
        width: 0;
        height: 0;
        border-radius: 50%;
        background: rgba(255, 255, 255, 0.1);
        transition: all 0.4s ease;
        transform: translate(-50%, -50%);
      }

      #quizForm button[type="button"]:hover::after {
        width: 300px;
        height: 300px;
      }

      #quizForm button[type="button"]:hover {
        background: linear-gradient(
          135deg,
          var(--fire-orange) 0%,
          var(--primary-purple) 100%
        );
        transform: translateY(-3px);
        box-shadow: 0 12px 35px rgba(107, 91, 141, 0.4);
      }

      /* Results Section */
      .result {
        margin-top: 40px;
        padding: 35px;
        border-radius: 20px;
        display: none;
        background: linear-gradient(
          135deg,
          rgba(255, 248, 240, 0.95),
          rgba(184, 169, 217, 0.1)
        );
        box-shadow: 0 15px 35px rgba(107, 91, 141, 0.15);
        animation: fadeIn 0.8s ease-out;
        border-top: 5px solid var(--primary-purple);
        position: relative;
      }

      .result::before {
        content: "";
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        border-radius: 20px;
        background: linear-gradient(
          45deg,
          transparent,
          rgba(107, 91, 141, 0.03),
          transparent
        );
        animation: shimmer 6s ease-in-out infinite;
      }

      .result h2 {
        color: var(--text-dark);
        text-align: center;
        margin-top: 0;
        font-size: 2.2rem;
        font-weight: 700;
        background: linear-gradient(
          135deg,
          var(--primary-purple),
          var(--fire-orange)
        );
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
      }

      .result p {
        font-size: 1.1rem;
        margin-bottom: 15px;
        line-height: 1.7;
      }

      .result strong {
        background: linear-gradient(
          135deg,
          var(--primary-purple),
          var(--fire-orange)
        );
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
      }

      .hidden {
        display: none;
      }

      /* Responsive Adjustments */
      @media (max-width: 768px) {
        #instructionContainer,
        #quizContainer {
          width: 90%;
          padding: 25px;
        }

        .welcome-header h1 {
          font-size: 2.2rem;
        }

        .start-btn {
          padding: 15px 35px;
          font-size: 1.1rem;
        }

        .question {
          padding: 20px;
        }

        .options label {
          padding: 12px 15px;
        }

        .tattva-element {
          display: none;
        }
      }

      /* Mouse movement parallax effect */
      @media (hover: hover) {
        .question {
          transform-style: preserve-3d;
        }
      }
    </style>
  </head>
  <body>
    <!-- Animated Background Elements - Five Tattvas -->
    <div class="background-elements">
      <!-- Air Elements -->
      <div class="tattva-element air-element air-1"></div>
      <div class="tattva-element air-element air-2"></div>
      <div class="tattva-element air-element air-3"></div>

      <!-- Water Elements -->
      <div class="tattva-element water-element water-1"></div>
      <div class="tattva-element water-element water-2"></div>

      <!-- Fire Elements -->
      <div class="tattva-element fire-element fire-1"></div>
      <div class="tattva-element fire-element fire-2"></div>

      <!-- Space Elements -->
      <div class="tattva-element space-element space-1"></div>
      <div class="tattva-element space-element space-2"></div>
      <div class="tattva-element space-element space-3"></div>
    </div>

    <!-- Welcome/Instruction Page -->
    <div id="instructionContainer">
      <div class="welcome-header">
        <div class="ayurveda-icon">☯</div>
        <h1>AYURVEDIC DOSHA QUIZ</h1>
        <p>
          Discover your unique mind-body constitution for optimal health and
          wellbeing
        </p>
      </div>

      <div class="instructions-section">
        <h2>How It Works</h2>
        <ul>
          <li>
            <strong>10 carefully crafted questions</strong> about your physical
            and mental characteristics
          </li>
          <li>
            Select the answers that
            <strong>most accurately describe you</strong> throughout your life
          </li>
          <li>
            Receive your <strong>personalized dosha profile</strong> with
            percentage breakdown
          </li>
          <li>
            Learn whether you're Vata, Pitta, Kapha, or a balanced combination
          </li>
          <li>Get insights to help bring your doshas into harmony</li>
        </ul>
      </div>

      <div class="dosha-benefits">
        <h3>The Power of Ayurveda</h3>
        <p>
          Ayurveda, the 5,000-year-old "science of life," teaches that
          understanding your dosha (mind-body type) is the key to optimal
          health. Your dosha influences everything from your digestion to your
          sleep patterns, emotions, and ideal exercise routine.
        </p>
        <p>
          This quiz will help you identify your dominant dosha so you can make
          lifestyle choices that create balance and wellbeing.
        </p>
      </div>

      <div class="disclaimer">
        <p>
          <strong>Note:</strong> This quiz provides general guidance based on
          Ayurvedic principles. For personalized health recommendations, please
          consult an Ayurvedic practitioner. This is not intended as medical
          advice.
        </p>
      </div>

      <div class="start-btn-container">
        <button
          class="start-btn"
          style="
            margin-left: 20px;
            background: linear-gradient(135deg, #4a90a4, #6b5b8d);
          "
          onclick="window.location.href='homepg.php'"
        >
          ← Back to Home
        </button>
        <button class="start-btn" onclick="startQuiz()">
          Begin Your Journey
        </button>
      </div>
    </div>

    <!-- Quiz Page -->
    <div id="quizContainer">
      <h1>Discover Your Dosha</h1>
      <form id="quizForm">
        <div class="question">
          <p>1.What is your Body Built Type?</p>
          <div class="options">
            <label
              ><input type="radio" name="q1" value="A" /><span
                >Thin,bony,small Framed and Hardly gain weight</span
              ></label
            >
            <label
              ><input type="radio" name="q1" value="B" /><span
                >Medium built, can gain or lose weight easily</span
              ></label
            >
            <label
              ><input type="radio" name="q1" value="C" /><span
                >Large built. Gain weight easily but find it difficult to lose
                it</span
              ></label
            >
          </div>
        </div>

        <div class="question">
          <p>2.Physical Activity (Pace of Walk/Talk)</p>
          <div class="options">
            <label
              ><input type="radio" name="q2" value="A" /><span
                >Hyperactive</span
              ></label
            >
            <label
              ><input type="radio" name="q2" value="B" /><span
                >Moderate</span
              ></label
            >
            <label
              ><input type="radio" name="q2" value="C" /><span
                >Sedentary</span
              ></label
            >
          </div>
        </div>

        <div class="question">
          <p>3. Choice of Climate</p>
          <div class="options">
            <label
              ><input type="radio" name="q3" value="A" /><span
                >Enjoy warm and uncomfortable in cool weather</span
              ></label
            >
            <label
              ><input type="radio" name="q3" value="B" /><span
                >Enjoy cool weather and dislike warm climate</span
              ></label
            >
            <label
              ><input type="radio" name="q3" value="C" /><span
                >Comfortable for most of the year but prefer summer and spring.
                Don't like damp climate</span
              ></label
            >
          </div>
        </div>

        <div class="question">
          <p>4.Sweating</p>
          <div class="options">
            <label
              ><input type="radio" name="q4" value="A" /><span
                >Little Sweat</span
              ></label
            >
            <label
              ><input type="radio" name="q4" value="B" /><span
                >Sweat a lot</span
              ></label
            >
            <label
              ><input type="radio" name="q4" value="C" /><span
                >Sweat when work hard</span
              ></label
            >
          </div>
        </div>

        <div class="question">
          <p>5. Skin Type</p>
          <div class="options">
            <label
              ><input type="radio" name="q5" value="A" /><span
                >Thin, Dry, Cold, Rough, Dark</span
              ></label
            >
            <label
              ><input type="radio" name="q5" value="B" /><span
                >Straight, Oily, Warm, Rosy</span
              ></label
            >
            <label
              ><input type="radio" name="q5" value="C" /><span
                >Thick, Oily, Cool, White</span
              ></label
            >
          </div>
        </div>

        <div class="question">
          <p>6. Memory</p>
          <div class="options">
            <label
              ><input type="radio" name="q6" value="A" /><span
                >Quick to learn, also quick to forget. Short term memory is
                good</span
              ></label
            >
            <label
              ><input type="radio" name="q6" value="B" /><span
                >Average speed of learning. But once learnt, never forgets</span
              ></label
            >
            <label
              ><input type="radio" name="q6" value="C" /><span
                >Slow to learn but remembers for a long time. Long term memory
                is good</span
              ></label
            >
          </div>
        </div>

        <div class="question">
          <p>7.Temper</p>
          <div class="options">
            <label
              ><input type="radio" name="q7" value="A" /><span
                >Restless Mind</span
              ></label
            >
            <label
              ><input type="radio" name="q7" value="B" /><span
                >Impatient and aggressive easily</span
              ></label
            >
            <label
              ><input type="radio" name="q7" value="C" /><span
                >Mind remains cool and calm</span
              ></label
            >
          </div>
        </div>

        <div class="question">
          <p>8. Actions</p>
          <div class="options">
            <label
              ><input type="radio" name="q8" value="A" /><span
                >Overthink</span
              ></label
            >
            <label
              ><input type="radio" name="q8" value="B" /><span
                >Quick Implementation</span
              ></label
            >
            <label
              ><input type="radio" name="q8" value="C" /><span
                >Lazy implementation. Has a tendency to procrastinate</span
              ></label
            >
          </div>
        </div>

        <div class="question">
          <p>9. Sleep Quality</p>
          <div class="options">
            <label
              ><input type="radio" name="q9" value="A" /><span
                >Light and Disturbed Sleep</span
              ></label
            >
            <label
              ><input type="radio" name="q9" value="B" /><span
                >Moderate can go back to sleep easily</span
              ></label
            >
            <label
              ><input type="radio" name="q9" value="C" /><span
                >Deep and heavy. Can't wake up easily in morning</span
              ></label
            >
          </div>
        </div>

        <div class="question">
          <p>10. Emotional Nature</p>
          <div class="options">
            <label
              ><input type="radio" name="q10" value="A" />Worry a lot, nervous
              and anxious</label
            >
            <label
              ><input type="radio" name="q10" value="B" /> Irritable, angry and
              impatient</label
            >
            <label
              ><input type="radio" name="q10" value="C" /> Loving and caring. It
              takes a lot to make me angry</label
            >
          </div>
        </div>

        <button type="button" onclick="calculateDosha()">
          Discover My Dosha
        </button>
        <button
          type="button"
          onclick="goBackToInstructions()"
          style="
            background: linear-gradient(135deg, #4a90a4, #6b5b8d);
            color: white;
            border: none;
            border-radius: 30px;
            padding: 12px 30px;
            font-size: 1rem;
          "
        >
          ← Back
        </button>
      </form>

      <div class="result" id="result"></div>
    </div>
    <script>
      let dominantDosha = "";

      function startQuiz() {
        document.getElementById("instructionContainer").style.display = "none";
        document.getElementById("quizContainer").style.display = "block";
        window.scrollTo(0, 0);
      }

      async function calculateDosha() {
        const form = document.getElementById("quizForm");
        const totalQuestions = 10;
        let answers = [];

        // Collect all answers
        for (let i = 1; i <= totalQuestions; i++) {
          const questionAnswers = form["q" + i];
          let checked = false;
          for (let radio of questionAnswers) {
            if (radio.checked) {
              checked = true;
              answers.push(radio.value);
              break;
            }
          }
          if (!checked) {
            alert(`Please answer question ${i} before submitting.`);
            return;
          }
        }

        // Show loading state
        const submitButton = document.querySelector(
          'button[onclick="calculateDosha()"]'
        );
        const originalText = submitButton.textContent;
        submitButton.textContent = "Calculating...";
        submitButton.disabled = true;
        try {
          // Send answers to Flask backend
          const response = await fetch("http://127.0.0.1:5000/predict", {
            method: "POST",
            headers: {
              "Content-Type": "application/json",
            },
            body: JSON.stringify({ answers: answers }),
          });

          if (!response.ok) {
            throw new Error(`HTTP error! status: ${response.status}`);
          }

          const data = await response.json();

          if (data.error) {
            throw new Error(data.error);
          }

          // Get the prediction from ML model
          dominantDosha = data.prediction.toLowerCase();
          sendDoshaToServer(dominantDosha);

          // Calculate percentages for display (manual calculation for UI)
          let vata = 0,
            pitta = 0,
            kapha = 0;
          answers.forEach((answer) => {
            if (answer === "A") vata++;
            else if (answer === "B") pitta++;
            else if (answer === "C") kapha++;
          });

          const total = vata + pitta + kapha;
          const vataPct = Math.round((vata / total) * 100);
          const pittaPct = Math.round((pitta / total) * 100);
          const kaphaPct = 100 - vataPct - pittaPct;

          // Display results
          let resultText = `<h2>Your Ayurvedic Constitution</h2>`;
          resultText += `
        <div style="margin: 20px 0;">
          <div style="background: #f0e6dd; padding: 15px; border-radius: 10px; margin-bottom: 10px;">
            <p><strong>Vata:</strong> ${vataPct}%</p>
          </div>
          <div style="background: #f0e6dd; padding: 15px; border-radius: 10px; margin-bottom: 10px;">
            <p><strong>Pitta:</strong> ${pittaPct}%</p>
          </div>
          <div style="background: #f0e6dd; padding: 15px; border-radius: 10px;">
            <p><strong>Kapha:</strong> ${kaphaPct}%</p>
          </div>
        </div>`;

          // Display ML prediction result
          const doshaDisplayName = getDoshaDisplayName(dominantDosha);
          resultText += `<p><strong>Based on AI Analysis, your primary dosha is:</strong> ${doshaDisplayName}</p>`;

          resultText += `
        <div style="margin-top: 20px; text-align: center;">
          <button onclick="reviewAnswers()" style="
            background: linear-gradient(135deg, #4a90a4, #6b5b8d);
            color: white;
            border: none;
            border-radius: 30px;
            padding: 12px 30px;
            font-size: 1rem;
          ">Review My Answers</button>
          <button onclick="proceedToNextPage()" style="
            background: linear-gradient(135deg, #6b5b8d, #4a90a4);
            color: white;
            border: none;
            border-radius: 30px;
            padding: 12px 30px;
            font-size: 1rem;
          ">Proceed</button>
        </div>
      `;

          form.classList.add("hidden");
          const resultDiv = document.getElementById("result");
          resultDiv.innerHTML = resultText;
          resultDiv.style.display = "block";
          window.scrollTo(0, document.body.scrollHeight);
        } catch (error) {
          console.error("Error calculating dosha:", error);
          alert(
            "Sorry, there was an error calculating your dosha. Please try again or check if the server is running."
          );
        } finally {
          // Reset button state
          submitButton.textContent = originalText;
          submitButton.disabled = false;
        }
      }

      function getDoshaDisplayName(dosha) {
        const doshaMap = {
          vata: "Vata",
          pitta: "Pitta",
          kapha: "Kapha",
          "vata & pitta": "Vata-Pitta Combination",
          "pitta & vata": "Vata-Pitta Combination",
          "kapha & pitta": "Kapha-Pitta Combination",
          "pitta & kapha": "Kapha-Pitta Combination",
          "vata & kapha": "Vata-Kapha Combination",
          "kapha & vata": "Vata-Kapha Combination",
          "vata & pitta & kapha": "Tridoshic (Balanced)",
        };
        return doshaMap[dosha]; // || dosha.charAt(0).toUpperCase() + dosha.slice(1)
      }
      function sendDoshaToServer(dosha) {
      fetch("update_dosha.php", {
        method: "POST",
        headers: {
        "Content-Type": "application/json"
    },
    body: JSON.stringify({ dosha: dosha })
  })
  .then(response => response.text())
  .then(data => console.log("Server response:", data))
  .catch(error => console.error("Error sending dosha to server:", error));
}

      function reviewAnswers() {
        document.getElementById("result").style.display = "none";
        document.getElementById("quizForm").classList.remove("hidden");
        window.scrollTo(0, 0);
      }

      function goBackToInstructions() {
        document.getElementById("quizContainer").style.display = "none";
        document.getElementById("instructionContainer").style.display = "block";
        window.scrollTo(0, 0);
      }

      function proceedToNextPage() {
        let pageMap = {
          vata: "vata_result.html",
          pitta: "pitta_result.html",
          kapha: "kapha_result.html",
          "vata & pitta": "vata_pitta.html",
          "pitta & vata": "vata_pitta.html",
          "kapha & pitta": "kapha_pitta.html",
          "pitta & kapha": "kapha_pitta.html",
          "vata & kapha": "vata_kapha.html",
          "kapha & vata": "vata_kapha.html",
          "vata & pitta & kapha": "tridosha.html",
        };

        console.log("Dominant Dosha:", dominantDosha);
        let nextPage = pageMap[dominantDosha];
        if (nextPage) {
          window.location.href = nextPage;
        } else {
          alert(
            "Unable to determine your dosha result. Please retake the quiz."
          );
        }
      }
    </script>
  </body>
</html>