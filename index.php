<?php require_once 'api/db_config.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Bible Insights - Student Assessment</title>
    <style>
        :root { --primary: #2d3748; --accent: #3182ce; --bg: #f7fafc; }
        body { font-family: 'Segoe UI', sans-serif; background: var(--bg); margin: 0; }
        .navbar { background: var(--primary); color: white; padding: 1rem 5%; display: flex; justify-content: space-between; align-items: center; }
        .container { max-width: 650px; margin: 3rem auto; padding: 0 1rem; }
        .card { background: white; padding: 2.5rem; border-radius: 12px; box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1); text-align: center; }
        
        input[type="text"], select { width: 100%; padding: 12px; margin: 10px 0 25px 0; border: 2px solid #e2e8f0; border-radius: 8px; font-size: 1rem; box-sizing: border-box; }
        button { width: 100%; padding: 16px; background: var(--accent); color: white; border: none; border-radius: 8px; cursor: pointer; font-weight: bold; font-size: 1.1rem; }
        button:hover { background: #2b6cb0; }
        .hidden { display: none; }

        .progress-bar { background: #edf2f7; height: 10px; border-radius: 5px; margin-bottom: 2rem; overflow: hidden; }
        .fill { background: var(--accent); height: 100%; transition: width 0.3s; width: 0%; }
        .q-text { font-size: 1.4rem; margin: 25px 0; font-weight: 600; line-height: 1.4; }
    </style>
</head>
<body>
    <nav class="navbar">
        <h1 onclick="location.reload()" style="cursor:pointer">BIBLE INSIGHTS</h1>
        <a href="leaderboard.php" style="color:white; text-decoration:none; font-weight:bold;">RANKINGS</a>
    </nav>

    <main class="container">
        <section id="setup">
            <div class="card">
                <h2 style="margin-top:0;">Final Examination</h2>
                <p style="color:#718096">Enter your details to begin the test.</p>
                
                <div style="text-align:left;">
                    <label>Full Name</label>
                    <input type="text" id="p-name" placeholder="Levi Gatimu Ngugi">

                    <label>Difficulty Level</label>
                    <select id="p-diff">
                        <option value="easy" selected>Easy (20 Questions)</option>
                        <option value="medium">Medium (10 Questions)</option>
                        <option value="hard">Hard (5 Questions)</option>
                    </select>
                </div>
                
                <button onclick="startExam()">BEGIN TEST</button>
            </div>
        </section>

        <section id="exam-area" class="hidden">
            <div class="progress-bar"><div id="fill" class="fill"></div></div>
            <div id="q-container" class="card"></div>
        </section>
    </main>

    <script>
        let questions = [];
        let currentIdx = 0;
        let correctCount = 0;
        let studentName = '';
        let difficulty = '';

        async function startExam() {
            studentName = document.getElementById('p-name').value.trim();
            difficulty = document.getElementById('p-diff').value;

            if(!studentName) return alert("Please enter your name.");

            document.getElementById('setup').classList.add('hidden');
            document.getElementById('exam-area').classList.remove('hidden');

            const response = await fetch(`api/get_questions.php?level=${difficulty}`);
            questions = await response.json();
            renderQuestion();
        }

        function renderQuestion() {
            const container = document.getElementById('q-container');
            const fill = document.getElementById('fill');
            
            fill.style.width = (currentIdx / questions.length) * 100 + "%";

            if(currentIdx >= questions.length) {
                showResults();
                return;
            }

            const q = questions[currentIdx];
            container.innerHTML = `
                <small style="color:#a0aec0; text-transform:uppercase;">Question ${currentIdx + 1} of ${questions.length}</small>
                <p class="q-text">${q.question}</p>
                <input type="text" id="ans-input" placeholder="Type your answer..." autocomplete="off">
                <button onclick="submitAnswer('${q.answer.toLowerCase()}')">NEXT</button>
            `;
            document.getElementById('ans-input').focus();
        }

        function submitAnswer(correct) {
            const val = document.getElementById('ans-input').value.toLowerCase().trim();
            if(val.includes(correct)) correctCount++;
            
            currentIdx++;
            renderQuestion();
        }

        async function showResults() {
            const finalScore = Math.round((correctCount / questions.length) * 100);
            const container = document.getElementById('q-container');
            
            container.innerHTML = `
                <h2>Examination Complete</h2>
                <p>Your results have been submitted successfully.</p>
                <h1 style="font-size: 5rem; color: var(--accent); margin: 20px 0;">${finalScore}%</h1>
                <button onclick="window.location.href='leaderboard.php'">VIEW LEADERBOARD</button>
            `;

            // Save results to DB
            await fetch('api/save_score.php', {
                method: 'POST',
                headers: {'Content-Type': 'application/json'},
                body: JSON.stringify({
                    name: studentName,
                    score: finalScore,
                    level: difficulty,
                    game: 'Final Bible Assessment'
                })
            });
        }
    </script>
</body>
</html>