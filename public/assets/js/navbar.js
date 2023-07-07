document.querySelector(".nav-menu-button").addEventListener('click', () => {

  const menu = document.querySelector('nav ul');

  menu.id = menu.id == 'closed' ? 'opened' : 'closed';

});
