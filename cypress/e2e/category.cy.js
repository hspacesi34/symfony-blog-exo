describe('Category form', () => {
	// NOTE: Ensure Cypress `baseUrl` is configured in cypress.config.js
	// or run tests with the full URL: cy.visit('http://localhost:8000/category/add')

	beforeEach(() => {
		cy.visit('/category/add');
	});

	it('adds a new category', () => {
		const name = `Cypress Cat ${Date.now()}`;
		const description = 'Category created by Cypress test';

		cy.get('[data-cy="name_cat"]').should('be.visible').type(name);
		cy.get('[data-cy="description_cat"]').should('be.visible').type(description);

		cy.contains('button', 'Enregistrer').click();

		// success flash message
		cy.get('.alert-success').should('contain.text', 'Catégorie ajoutée avec succès');

		// form should be cleared after successful submission (service clears it)
		cy.get('[data-cy="name_cat"]').should('have.value', '');
	});

	it('shows required validation errors when fields are empty', () => {
		// submit without filling fields
		cy.contains('button', 'Enregistrer').click();

		// 'NotBlank' messages
		cy.contains('Merci d\'entrer un nom').should('be.visible');
		cy.contains('Merci d\'entrer une description').should('be.visible');

		// inputs marked invalid
		cy.get('[data-cy="name_cat"]').should('have.class', 'is-invalid');
		cy.get('[data-cy="description_cat"]').should('have.class', 'is-invalid');
	});

	it('validates min length for name and description', () => {
		// name too short
		cy.get('[data-cy="name_cat"]').type('A');
		// description valid so only name triggers
		cy.get('[data-cy="description_cat"]').type('Valid description');
		cy.contains('button', 'Enregistrer').click();

		cy.contains('Le nom doit contenir 2 caractères').should('be.visible');
		cy.get('[data-cy="name_cat"]').should('have.class', 'is-invalid');

		// now test description min length
		cy.get('[data-cy="name_cat"]').clear().type('Valid name');
	cy.get('[data-cy="description_cat"]').clear().type('A');
	cy.contains('button', 'Enregistrer').click();

	cy.contains('La description doit contenir 2 caractères').should('be.visible');
	cy.get('[data-cy="description_cat"]').should('have.class', 'is-invalid');
	});

	it('validates max length for name', () => {
		const long = 'x'.repeat(60);
		cy.get('[data-cy="name_cat"]').type(long);
		cy.get('[data-cy="description_cat"]').type('Valid description');
		cy.contains('button', 'Enregistrer').click();

		// input should be marked invalid
		cy.get('[data-cy="name_cat"]').should('have.class', 'is-invalid');

		// default length message includes the limit number (50)
		cy.get('body').then(($b) => {
			if ($b.text().includes('50')) {
				cy.contains('50').should('be.visible');
			} else {
				// fallback: ensure an error message exists for the field
				cy.get('[data-cy="name_cat"]').parent().find('.invalid-feedback, .form-error-message, .alert-danger').should('exist');
			}
		});
	});
});