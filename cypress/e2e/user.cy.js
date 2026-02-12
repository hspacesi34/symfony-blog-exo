describe('register', () => {
  it('passes', () => {
    cy.visit('http://localhost:8000/register')
    const name_user = "Jarry";
    cy.get('[data-cy="name_user"]').type(name_user)
    const firstname_user = "Cédric";
    cy.get('[data-cy="firstname_user"]').type(firstname_user)
    const email_user = "oiylyililiyrjyj@gmail.com";
    cy.get('[data-cy="email_user"]').type(email_user)
    const password = "testtest";
    cy.get('[data-cy="plainPassword"]').type(password)
    cy.get('[data-cy="agreeTerms"]').click()

    cy.get('[data-cy="submit"]').click()
    cy.wait(2000);

    const msgValidation = "Enregistrement bien effectué";

    cy.get('[data-cy="msgValidation"]').should('contain', msgValidation)
  })
  it('email_user already exists', () => {
    cy.visit('http://localhost:8000/register')
    const name_user = "Jarry";
    cy.get('[data-cy="name_user"]').type(name_user)
    const firstname_user = "Cédric";
    cy.get('[data-cy="firstname_user"]').type(firstname_user)
    const email_user = "oiylyililiyrjyj@gmail.com";
    cy.get('[data-cy="email_user"]').type(email_user)
    const password = "testtest";
    cy.get('[data-cy="plainPassword"]').type(password)
    cy.get('[data-cy="agreeTerms"]').click()

    cy.get('[data-cy="submit"]').click()
    cy.wait(2000);

    const msgValidation = "There is already an account with this email_user";

    cy.get('#registration_form_email_user_error1').should('contain', msgValidation)
  })
  it('name_user fails', () => {
    cy.visit('http://localhost:8000/register')
    const name_user = "J";
    cy.get('[data-cy="name_user"]').type(name_user)
    const firstname_user = "Cédric";
    cy.get('[data-cy="firstname_user"]').type(firstname_user)
    const email_user = "jetjjetjt@etjejttje.com";
    cy.get('[data-cy="email_user"]').type(email_user)
    const password = "testtest";
    cy.get('[data-cy="plainPassword"]').type(password)
    cy.get('[data-cy="agreeTerms"]').click()

    cy.get('[data-cy="submit"]').click()
    cy.wait(2000);

    const msgValidation = "Le nom doit contenir 2 caractères";

    cy.get('#registration_form_name_user_error1').should('contain', msgValidation)
  })
  it('firstname_user fails', () => {
    cy.visit('http://localhost:8000/register')
    const name_user = "Jarry";
    cy.get('[data-cy="name_user"]').type(name_user)
    const firstname_user = "C";
    cy.get('[data-cy="firstname_user"]').type(firstname_user)
    const email_user = "jetjjetjt@etjejttje.com";
    cy.get('[data-cy="email_user"]').type(email_user)
    const password = "testtest";
    cy.get('[data-cy="plainPassword"]').type(password)
    cy.get('[data-cy="agreeTerms"]').click()

    cy.get('[data-cy="submit"]').click()
    cy.wait(2000);

    const msgValidation = "Le prénom doit contenir 2 caractères";

    cy.get('#registration_form_firstname_user_error1').should('contain', msgValidation)
  })
})