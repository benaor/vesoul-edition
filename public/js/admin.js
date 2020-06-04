// Date actuelle en français
var optionsDate = {weekday: 'long', year: 'numeric', month: 'long', day: 'numeric'};

// inserer la date dans le dashboard Admin
document.querySelector('.dateActuelle').textContent = `${new Date(Date.now()).toLocaleDateString('fr-FR', optionsDate)}`;

