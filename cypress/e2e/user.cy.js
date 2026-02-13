describe('Formulaire inscription /register', () => {
  const validUserBase = {
    name_user: 'Jarry',
    firstname_user: 'Cedric',
    plainPassword: 'testtest',
  };

  beforeEach(() => {
    cy.visit('/register');
  });

  it('soumet le formulaire avec succès', () => {
    cy.uniqueEmail().then((email) => {
      cy.fillRegistrationForm({
        ...validUserBase,
        email_user: email,
      });

      cy.get('[data-cy="submit"]').click();
      cy.get('[data-cy="msgValidation"]').should('contain', 'Enregistrement bien effectué');
    });
  });

  it('refuse un email déjà existant', () => {
    cy.uniqueEmail().then((email) => {
      cy.fillRegistrationForm({
        ...validUserBase,
        email_user: email,
      });
      cy.get('[data-cy="submit"]').click();
      cy.get('[data-cy="msgValidation"]').should('contain', 'Enregistrement bien effectué');

      cy.visit('/register');
      cy.fillRegistrationForm({
        ...validUserBase,
        email_user: email,
      });
      cy.get('[data-cy="submit"]').click();

      cy.contains('There is already an account with this email_user').should('be.visible');
    });
  });

  it('refuse un nom trop court', () => {
    cy.uniqueEmail().then((email) => {
      cy.fillRegistrationForm({
        ...validUserBase,
        name_user: 'J',
        email_user: email,
      });

      cy.get('[data-cy="submit"]').click();
      cy.contains('Le nom doit contenir 2 caractères').should('be.visible');
    });
  });

  it('refuse un prénom trop court', () => {
    cy.uniqueEmail().then((email) => {
      cy.fillRegistrationForm({
        ...validUserBase,
        firstname_user: 'C',
        email_user: email,
      });

      cy.get('[data-cy="submit"]').click();
      cy.contains('Le prénom doit contenir 2 caractères').should('be.visible');
    });
  });

  it('refuse un mot de passe trop court', () => {
    cy.uniqueEmail().then((email) => {
      cy.fillRegistrationForm({
        ...validUserBase,
        email_user: email,
        plainPassword: '12345',
      });

      cy.get('[data-cy="submit"]').click();
      cy.contains('Le mot de passe doit contenir 6 caractères').should('be.visible');
    });
  });

  it('refuse si les CGU ne sont pas cochées', () => {
    cy.uniqueEmail().then((email) => {
      cy.fillRegistrationForm({
        ...validUserBase,
        email_user: email,
        agreeTerms: false,
      });

      cy.get('[data-cy="submit"]').click();
      cy.contains('You should agree to our terms.').should('be.visible');
    });
  });
});