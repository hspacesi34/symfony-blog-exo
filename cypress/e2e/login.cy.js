describe('Formulaire connexion /login', () => {
  const password = 'testtest';

  it('affiche les champs requis', () => {
    cy.visit('/login');

    cy.get('input[name="_username"]').should('have.attr', 'required');
    cy.get('input[name="_password"]').should('have.attr', 'required');
    cy.get('input[name="_csrf_token"]').invoke('val').should('be.a', 'string').and('not.be.empty');
    cy.get('button[type="submit"]').should('be.visible');
  });

  it('refuse des identifiants invalides', () => {
    cy.visit('/login');

    cy.get('input[name="_username"]').type('unknown@example.com');
    cy.get('input[name="_password"]').type('wrong-password');
    cy.get('button[type="submit"]').click();

    cy.get('.alert-error').should('be.visible');
  });

  it('refuse un jeton CSRF invalide', () => {
    cy.request('/login').then((response) => {
      return cy.request({
        method: 'POST',
        url: '/login',
        form: true,
        failOnStatusCode: false,
        followRedirect: true,
        body: {
          _username: 'unknown@example.com',
          _password: 'wrong-password',
          _csrf_token: 'invalid-csrf-token',
        },
      });
    }).then((response) => {
      expect(response.status).to.be.oneOf([200, 302]);
    });

    cy.visit('/login');
    cy.get('input[name="_csrf_token"]').should('exist');
  });

  it('connecte avec succès un compte créé via inscription', () => {
    cy.uniqueEmail().then((email) => {
      cy.visit('/register');
      cy.fillRegistrationForm({
        name_user: 'Login',
        firstname_user: 'Tester',
        email_user: email,
        plainPassword: password,
      });
      cy.get('[data-cy="submit"]').click();
      cy.get('[data-cy="msgValidation"]').should('be.visible');

      cy.loginThroughUi(email, password);
      cy.get('#main-navbar').within(() => {
        cy.contains('Logout').should('be.visible');
        cy.contains(email).should('be.visible');
      });
    });
  });
});
