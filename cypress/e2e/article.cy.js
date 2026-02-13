describe('Formulaire article /article/add', () => {
  beforeEach(() => {
    cy.visit('/article/add');
  });

  it('affiche tous les champs du formulaire', () => {
    cy.get('input[name="article[title_article]"]').should('be.visible');
    cy.get('textarea[name="article[content_article]"]').should('be.visible');
    cy.get('input[name="article[image_article]"]').should('be.visible');
    cy.get('select[name="article[categories][]"]').should('be.visible');
    cy.get('button[type="submit"]').should('be.visible');
  });

  it('refuse une soumission vide', () => {
    cy.get('button[type="submit"]').click();

    cy.contains('Le titre ne peut pas être vide').should('be.visible');
    cy.contains('Le contenu ne peut pas être vide').should('be.visible');
  });

  it('soumet un article valide', () => {
    const uniqueValue = `${Date.now()}_${Cypress._.random(1000, 9999)}`;

    cy.get('input[name="article[title_article]"]').type(`Article e2e ${uniqueValue}`);
    cy.get('textarea[name="article[content_article]"]').type('Contenu e2e valide pour un test Cypress.');
    cy.get('input[name="article[image_article]"]').selectFile('cypress/fixtures/example.json', { force: true });

    cy.get('select[name="article[categories][]"] option').then(($options) => {
      const firstValue = $options.first().val();
      cy.get('select[name="article[categories][]"]').select([`${firstValue}`], { force: true });
    });

    cy.get('button[type="submit"]').click();
    cy.contains('Article ajouté avec succès').should('be.visible');
  });
});
