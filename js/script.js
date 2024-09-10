function showPopup(packageID) {
    window.location.href = `selectDuration.php?packageID=${packageID}`;
}

function hidePopup() {
    document.getElementById('popup').style.display = 'none';
    document.getElementById('overlay').style.display = 'none';
}

function showTrainerPopup(packageID, duration) {
    window.location.href = `selectTrainer.php?packageID=${packageID}&duration=${duration}`;
}

function hideTrainerPopup() {
    document.getElementById('trainerPopup').style.display = 'none';
    document.getElementById('overlay').style.display = 'none';
}

function showSchedulePopup(packageID, duration, trainer) {
    window.location.href = `selectSchedule.php?packageID=${packageID}&duration=${duration}&trainer=${trainer}`;
}

function hideSchedulePopup() {
    document.getElementById('schedulePopup').style.display = 'none';
    document.getElementById('overlay').style.display = 'none';
}

function closeSuccessPopup() {
    document.querySelector('.success-popup').style.display = 'none';
    // Redirect to member dashboard or home page
    window.location.href = 'index.php';
}