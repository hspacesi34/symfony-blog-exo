describe('Formulaire catégorie /category/add', () => {
	beforeEach(() => {
		cy.visit('/category/add');
	});

	it('soumet une nouvelle catégorie avec succès', () => {
		const uniqueValue = `${Date.now()}_${Cypress._.random(1000, 9999)}`;
		const name = `e2e-category-${uniqueValue}`;

		cy.get('[data-cy="name_cat"]').clear().type(name);
		cy.get('[data-cy="description_cat"]').clear().type('Description e2e valide pour catégorie.');
		cy.get('button[type="submit"]').click();

		cy.contains('Catégorie ajoutée avec succès').should('be.visible');
	});

	it('refuse une catégorie déjà existante', () => {
		const uniqueValue = `${Date.now()}_${Cypress._.random(1000, 9999)}`;
		const name = `e2e-category-${uniqueValue}`;

		cy.get('[data-cy="name_cat"]').clear().type(name);
		cy.get('[data-cy="description_cat"]').clear().type('Première création catégorie.');
		cy.get('button[type="submit"]').click();
		cy.contains('Catégorie ajoutée avec succès').should('be.visible');

		cy.get('[data-cy="name_cat"]').clear().type(name);
		cy.get('[data-cy="description_cat"]').clear().type('Deuxième création catégorie.');
		cy.get('button[type="submit"]').click();

		cy.contains('Cette catégorie existe déjà').should('be.visible');
	});

	it('refuse un nom trop court', () => {
		cy.get('[data-cy="name_cat"]').clear().type('A');
		cy.get('[data-cy="description_cat"]').clear().type('Description valide.');
		cy.get('button[type="submit"]').click();

		cy.contains(/Le nom doit contenir 2 caractères|Min 3 caractères/).should('be.visible');
	});

	it('refuse une description vide', () => {
		const uniqueValue = `${Date.now()}_${Cypress._.random(1000, 9999)}`;

		cy.get('[data-cy="name_cat"]').clear().type(`e2e-category-${uniqueValue}`);
		cy.get('[data-cy="description_cat"]').clear();
		cy.get('button[type="submit"]').click();

		cy.contains(/Merci d'entrer une description|La description ne peut pas être vide/).should('be.visible');
	});
});
