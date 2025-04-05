USE dteaches;

INSERT INTO categoria (titulo, conteudo) VALUES 
('Saudações e Apresentações', 'Aprenda expressões essenciais para cumprimentar pessoas, apresentar-se e iniciar conversas básicas em inglês.'),
('No Hotel', 'Expressões úteis para fazer check-in, solicitar serviços e resolver problemas no hotel durante a sua estadia.'),
('Restaurantes e Alimentação', 'Como fazer pedidos, perguntar sobre o menu e pedir a conta em inglês quando estiver em restaurantes ou cafés.'),
('Transportes', 'Vocabulário e frases para utilizar diferentes meios de transporte, comprar bilhetes e pedir informações.'),
('Emergências', 'Expressões cruciais para situações de emergência, como pedir ajuda médica ou relatar problemas.'),
('Compras', 'Frases úteis para fazer compras, perguntar preços e negociar em lojas e mercados.'),
('Direções e Localizações', 'Como pedir e entender direções, perguntar por locais e usar mapas em inglês.');

-- Saudações e Apresentações
INSERT INTO expressoes (versao_ingles, traducao_portugues, id_categoria) VALUES
('Hello, how are you?', 'Olá, como estás?', 1),
('Good morning!', 'Bom dia!', 1),
('Good afternoon!', 'Boa tarde!', 1),
('Good evening!', 'Boa noite!', 1),
('My name is...', 'O meu nome é...', 1),
('Nice to meet you!', 'Prazer em conhecer-te!', 1),
('Where are you from?', 'De onde és?', 1),
('I am from Portugal', 'Eu sou de Portugal', 1),
('Do you speak English?', 'Falas inglês?', 1),
('I don''t speak English very well', 'Não falo inglês muito bem', 1);

-- No Hotel
INSERT INTO expressoes (versao_ingles, traducao_portugues, id_categoria) VALUES
('I have a reservation', 'Tenho uma reserva', 2),
('What time is check-out?', 'A que horas é o check-out?', 2),
('Is breakfast included?', 'O pequeno-almoço está incluído?', 2),
('Do you have WiFi?', 'Têm WiFi?', 2),
('The air conditioning is not working', 'O ar condicionado não está a funcionar', 2),
('Can I have more towels, please?', 'Posso ter mais toalhas, por favor?', 2),
('Where is the elevator?', 'Onde fica o elevador?', 2),
('What floor is my room on?', 'Em que andar fica o meu quarto?', 2),
('Can you recommend a good restaurant nearby?', 'Pode recomendar um bom restaurante nas proximidades?', 2),
('I would like to extend my stay', 'Gostaria de prolongar a minha estadia', 2);

-- Restaurantes e Alimentação
INSERT INTO expressoes (versao_ingles, traducao_portugues, id_categoria) VALUES
('A table for two, please', 'Uma mesa para dois, por favor', 3),
('Can I see the menu, please?', 'Posso ver o menu, por favor?', 3),
('What do you recommend?', 'O que recomenda?', 3),
('I am vegetarian', 'Sou vegetariano', 3),
('I am allergic to...', 'Sou alérgico a...', 3),
('Can I have the bill, please?', 'Pode trazer-me a conta, por favor?', 3),
('Is service included?', 'O serviço está incluído?', 3),
('How spicy is this dish?', 'Quão picante é este prato?', 3),
('Do you accept credit cards?', 'Aceitam cartões de crédito?', 3),
('It was delicious!', 'Estava delicioso!', 3);

-- Transportes
INSERT INTO expressoes (versao_ingles, traducao_portugues, id_categoria) VALUES
('How do I get to the city center?', 'Como chego ao centro da cidade?', 4),
('Where is the nearest bus stop?', 'Onde fica a paragem de autocarro mais próxima?', 4),
('I need a ticket to...', 'Preciso de um bilhete para...', 4),
('What time is the next train?', 'A que horas é o próximo comboio?', 4),
('Is this the right bus for...?', 'Este é o autocarro certo para...?', 4),
('How much is a taxi to the airport?', 'Quanto custa um táxi para o aeroporto?', 4),
('Can you take me to this address?', 'Pode levar-me para este endereço?', 4),
('Where can I rent a car?', 'Onde posso alugar um carro?', 4),
('Is there a metro station nearby?', 'Há alguma estação de metro por perto?', 4),
('Which platform does the train leave from?', 'De qual plataforma parte o comboio?', 4);

-- Emergências
INSERT INTO expressoes (versao_ingles, traducao_portugues, id_categoria) VALUES
('Help!', 'Socorro!', 5),
('I need a doctor', 'Preciso de um médico', 5),
('Call an ambulance, please!', 'Chame uma ambulância, por favor!', 5),
('Where is the nearest hospital?', 'Onde fica o hospital mais próximo?', 5),
('I lost my passport', 'Perdi o meu passaporte', 5),
('I''ve been robbed', 'Fui roubado', 5),
('Where is the police station?', 'Onde fica a esquadra de polícia?', 5),
('I am not feeling well', 'Não me estou a sentir bem', 5),
('Is there a pharmacy nearby?', 'Há alguma farmácia por perto?', 5),
('I am allergic to this medication', 'Sou alérgico a esta medicação', 5);

-- Compras
INSERT INTO expressoes (versao_ingles, traducao_portugues, id_categoria) VALUES
('How much does this cost?', 'Quanto custa isto?', 6),
('Do you have this in a different size?', 'Tem isto num tamanho diferente?', 6),
('Can I try it on?', 'Posso experimentar?', 6),
('I''m just looking, thanks', 'Estou apenas a ver, obrigado', 6),
('Do you accept euros?', 'Aceitam euros?', 6),
('That''s too expensive', 'Isso é demasiado caro', 6),
('Can you give me a discount?', 'Pode fazer-me um desconto?', 6),
('Where is the fitting room?', 'Onde fica o provador?', 6),
('Do you have this in blue?', 'Tem isto em azul?', 6),
('I will take it', 'Vou levar', 6);

-- Direções e Localizações
INSERT INTO expressoes (versao_ingles, traducao_portugues, id_categoria) VALUES
('Excuse me, where is...?', 'Com licença, onde fica...?', 7),
('How far is it?', 'A que distância fica?', 7),
('Can you show me on the map?', 'Pode mostrar-me no mapa?', 7),
('Turn left/right', 'Vire à esquerda/direita', 7),
('Go straight ahead', 'Siga em frente', 7),
('It''s near/next to...', 'É perto/ao lado de...', 7),
('Is it within walking distance?', 'Fica a uma distância que se pode ir a pé?', 7),
('I am lost', 'Estou perdido', 7),
('Where is the tourist information center?', 'Onde fica o posto de turismo?', 7),
('How do I get back to my hotel?', 'Como volto para o meu hotel?', 7);