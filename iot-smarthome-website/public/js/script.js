// Toggle Dark Mode
const darkModeToggle = document.getElementById('dark-mode-toggle');
const body = document.body;

if (localStorage.getItem('darkMode') === 'true') {
  body.classList.add('dark-mode');
  darkModeToggle.checked = true;
}

darkModeToggle.addEventListener('change', () => {
  body.classList.toggle('dark-mode');
  localStorage.setItem('darkMode', body.classList.contains('dark-mode'));
});

// Real-time Device and Rule Updates
const deviceStatusElements = document.querySelectorAll('.device-status');
const ruleStatusElements = document.querySelectorAll('.rule-status');

function updateDeviceStatus() {
  deviceStatusElements.forEach(element => {
    const deviceId = element.dataset.deviceId;
    // Make AJAX request to fetch the latest device status
    fetchDeviceStatus(deviceId)
      .then(status => {
        element.textContent = status;
      })
      .catch(error => {
        console.error('Error fetching device status:', error);
      });
  });
}

function updateRuleStatus() {
  ruleStatusElements.forEach(element => {
    const ruleId = element.dataset.ruleId;
    // Make AJAX request to fetch the latest rule status
    fetchRuleStatus(ruleId)
      .then(status => {
        element.textContent = status;
      })
      .catch(error => {
        console.error('Error fetching rule status:', error);
      });
  });
}

// Call the update functions every 5 seconds
setInterval(updateDeviceStatus, 5000);
setInterval(updateRuleStatus, 5000);

// Helper functions for AJAX requests
function fetchDeviceStatus(deviceId) {
  return fetch(`/api/devices/${deviceId}/status`)
    .then(response => response.json())
    .then(data => data.status);
}

function fetchRuleStatus(ruleId) {
  return fetch(`/api/rules/${ruleId}/status`)
    .then(response => response.json())
    .then(data => data.status);
}
