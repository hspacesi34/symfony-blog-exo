// ***********************************************
// This example commands.js shows you how to
// create various custom commands and overwrite
// existing commands.
//
// For more comprehensive examples of custom
// commands please read more here:
// https://on.cypress.io/custom-commands
// ***********************************************
//
//
// -- This is a parent command --
// Cypress.Commands.add('login', (email, password) => { ... })
//
//
// -- This is a child command --
// Cypress.Commands.add('drag', { prevSubject: 'element'}, (subject, options) => { ... })
//
//
// -- This is a dual command --
// Cypress.Commands.add('dismiss', { prevSubject: 'optional'}, (subject, options) => { ... })
//
//
// -- This will overwrite an existing command --
// Cypress.Commands.overwrite('visit', (originalFn, url, options) => { ... })

Cypress.Commands.add('uniqueEmail', () => {
	const uniqueValue = `${Date.now()}_${Cypress._.random(1000, 9999)}`;
	return cy.wrap(`e2e_${uniqueValue}@example.com`);
});

Cypress.Commands.add('fillRegistrationForm', ({
	name_user,
	firstname_user,
	email_user,
	plainPassword,
	agreeTerms = true,
}) => {
	cy.get('[data-cy="name_user"]').clear().type(name_user);
	cy.get('[data-cy="firstname_user"]').clear().type(firstname_user);
	cy.get('[data-cy="email_user"]').clear().type(email_user);
	cy.get('[data-cy="plainPassword"]').clear().type(plainPassword);

	if (agreeTerms) {
		cy.get('[data-cy="agreeTerms"]').check({ force: true });
	} else {
		cy.get('[data-cy="agreeTerms"]').uncheck({ force: true });
	}
});

Cypress.Commands.add('loginThroughUi', (email, password) => {
	cy.visit('/login');
	cy.get('input[name="_username"]').clear().type(email);
	cy.get('input[name="_password"]').clear().type(password);
	cy.get('button[type="submit"]').click();
});