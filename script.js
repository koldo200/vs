// Variables to store vote counts
let bullVotes = 0;
let bearVotes = 0;

// Capture the form and result div
const form = document.getElementById('poll-form');
const resultDiv = document.getElementById('result');
const bullVotesSpan = document.getElementById('bull-votes');
const bearVotesSpan = document.getElementById('bear-votes');

// Add submit event listener to the form
form.addEventListener('submit', function (e) {
    e.preventDefault(); // Prevent page reload

    // Get the selected value
    const vote = document.querySelector('input[name="vote"]:checked').value;

    // Update the vote count based on the selected vote
    if (vote === 'bull') {
        bullVotes++;
        resultDiv.innerHTML = "<p>You voted for Bull 🐂. Thank you for your vote!</p>";
    } else if (vote === 'bear') {
        bearVotes++;
        resultDiv.innerHTML = "<p>You voted for Bear 🐻. Thank you for your vote!</p>";
    }

    // Update the results display
    bullVotesSpan.textContent = bullVotes;
    bearVotesSpan.textContent = bearVotes;
});
