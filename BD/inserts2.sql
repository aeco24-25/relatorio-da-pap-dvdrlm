USE dteaches;

-- Inserir categorias
INSERT INTO categoria (titulo) VALUES 
('Saudações e Apresentações'),
('No Hotel'),
('Restaurantes e Alimentação'),
('Transportes'),
('Emergências'),
('Compras'),
('Direções e Localizações'),
('Trabalho e Negócios'),
('Tecnologia e Internet'),
('Lazer e Entretenimento');

-- =============================================
-- SAUDAÇÕES E APRESENTAÇÕES (6 expressões)
-- =============================================
INSERT INTO expressoes (versao_ingles, traducao_portugues, id_categoria, explicacao, tipo_exercicio) VALUES
('Hello, how are you?', 'Olá, como estás?', 1, 'Forma comum de cumprimentar alguém em inglês. Pode ser usado em qualquer situação, formal ou informal.', 'traducao'),
('Good morning!', 'Bom dia!', 1, 'Usado até aproximadamente meio-dia. Em situações formais, pode ser seguido pelo nome da pessoa.', 'preenchimento'),
('My name is...', 'Chamo-me...', 1, 'Frase essencial para se apresentar. Em contextos informais, pode-se usar apenas I am...', 'associacao'),
('Nice to meet you!', 'Prazer em conhecer-te!', 1, 'Usado quando se conhece alguém pela primeira vez. Em situações formais, pode-se dizer Pleased to meet you', 'traducao'),
('Where are you from?', 'De onde és?', 1, 'Pergunta comum em conversas iniciais. Resposta típica: I am from... seguido do país/cidade.', 'preenchimento'),
('Do you speak English?', 'Falas inglês?', 1, 'Pergunta útil quando não se tem certeza sobre o idioma do interlocutor.', 'associacao');

-- Exemplos para Saudações e Apresentações
INSERT INTO exemplos (id_expressao, exemplo) VALUES
(1, 'Hello, how are you? disse o colega quando me viu chegar.'),
(2, 'Good morning, Dr. Silva! cumprimentou a enfermeira.'),
(3, 'My name is Pedro apresentei-me aos novos colegas.'),
(4, 'Nice to meet you, respondeu ela com um aperto de mão.'),
(5, 'Where are you from? perguntou o taxista curioso.'),
(6, 'Do you speak English? perguntei ao funcionário do museu.');

-- Exercícios de preenchimento para Saudações
INSERT INTO exercicio_preenchimento (id_expressao, texto_com_lacunas, palavras_chave) VALUES
(2, '______ morning! How are you today?', '["Good"]'),
(5, 'Where are you ______? I am from ______.', '["from", "Portugal"]');

-- Exercícios de associação para Saudações
INSERT INTO exercicio_associacao (id_expressao, itens_ingles, itens_portugues) VALUES
(3, '["My name is", "Hello", "Goodbye"]', '["Chamo-me", "Olá", "Adeus"]'),
(6, '["Do you speak", "I understand", "I need"]', '["Falas", "Compreendo", "Preciso"]');

-- =============================================
-- NO HOTEL (6 expressões)
-- =============================================
INSERT INTO expressoes (versao_ingles, traducao_portugues, id_categoria, explicacao, tipo_exercicio) VALUES
('I have a reservation', 'Tenho uma reserva', 2, 'Frase essencial ao chegar ao hotel. Geralmente seguida pelo nome sob o qual a reserva foi feita.', 'traducao'),
('What time is check-out?', 'A que horas é a saída?', 2, 'Pergunta importante para planear a sua partida. A maioria dos hotéis tem check-out ao meio-dia.', 'preenchimento'),
('Is breakfast included?', 'O pequeno-almoço está incluído?', 2, 'Pergunta sobre serviços incluídos no preço. Alguns hotéis oferecem pequeno-almoço gratuito.', 'associacao'),
('Do you have WiFi?', 'Têm internet sem fios?', 2, 'Pergunta sobre internet disponível. Pode-se acrescentar Is it free? para saber se é gratuito.', 'traducao'),
('The air conditioning is not working', 'O ar condicionado não está a funcionar', 2, 'Frase para reportar problemas no quarto. Pode ser adaptada para outros problemas.', 'preenchimento'),
('Where is the elevator?', 'Onde fica o elevador?', 2, 'Pergunta sobre localização no hotel. Em inglês britânico diz-se lift.', 'associacao');

-- Exemplos para No Hotel
INSERT INTO exemplos (id_expressao, exemplo) VALUES
(7, 'I have a reservation under the name Oliveira disse ao rececionista.'),
(8, 'What time is check-out? perguntei para planear a viagem.'),
(9, 'Is breakfast included? queria saber se podia comer no hotel.'),
(10, 'Do you have WiFi in the rooms? perguntei ao fazer check-in.'),
(11, 'Liguei para a receção: The air conditioning is not working in room 304'),
(12, 'Where is the elevator? perguntei com as malas pesadas.');

-- Exercícios de preenchimento para Hotel
INSERT INTO exercicio_preenchimento (id_expressao, texto_com_lacunas, palavras_chave) VALUES
(8, 'What time is ______? The ______ is at 12:00.', '["check-out", "check-out"]'),
(11, 'The ______ conditioning is not ______. Can you fix it?', '["air", "working"]');

-- Exercícios de associação para Hotel
INSERT INTO exercicio_associacao (id_expressao, itens_ingles, itens_portugues) VALUES
(9, '["breakfast", "WiFi", "pool"]', '["pequeno-almoço", "internet", "piscina"]'),
(12, '["elevator", "room", "lobby"]', '["elevador", "quarto", "recepção"]');

-- =============================================
-- RESTAURANTES E ALIMENTAÇÃO (6 expressões)
-- =============================================
INSERT INTO expressoes (versao_ingles, traducao_portugues, id_categoria, explicacao, tipo_exercicio) VALUES
('A table for two, please', 'Uma mesa para dois, por favor', 3, 'Pedido básico ao chegar ao restaurante. Substitua two pelo número de pessoas.', 'traducao'),
('Can I see the menu, please?', 'Posso ver a ementa, por favor?', 3, 'Pedido para ver o cardápio. Em alguns lugares o menu é chamado de bill of fare.', 'preenchimento'),
('I am vegetarian', 'Sou vegetariano', 3, 'Informação importante sobre restrições alimentares.', 'associacao'),
('Can I have the bill, please?', 'Pode trazer a conta, por favor?', 3, 'Pedido para pagar a conta. Nos EUA é comum dizer check.', 'traducao'),
('How spicy is this dish?', 'Quão picante é este prato?', 3, 'Pergunta importante para quem não tolera comida muito picante.', 'preenchimento'),
('It was delicious!', 'Estava delicioso!', 3, 'Elogio à comida. Pode usar The food was excellent.', 'associacao');

-- Exemplos para Restaurantes e Alimentação
INSERT INTO exemplos (id_expressao, exemplo) VALUES
(13, 'A table for two, please pedimos ao maître.'),
(14, 'Can I see the menu, please? pedi ao empregado.'),
(15, 'I am vegetarian. Are there vegetarian options?'),
(16, 'No final da refeição: Can I have the bill, please?'),
(17, 'How spicy is this dish? I prefer mild food'),
(18, 'Ao sair: It was delicious! Well come back!');

-- Exercícios de preenchimento para Restaurantes
INSERT INTO exercicio_preenchimento (id_expressao, texto_com_lacunas, palavras_chave) VALUES
(14, 'Can I see the ______, please? Here is our ______.', '["menu", "menu"]'),
(17, 'How ______ is this ______? Is it very spicy?', '["spicy", "dish"]');

-- Exercícios de associação para Restaurantes
INSERT INTO exercicio_associacao (id_expressao, itens_ingles, itens_portugues) VALUES
(15, '["vegetarian", "vegan", "gluten-free"]', '["vegetariano", "vegano", "sem glúten"]'),
(18, '["delicious", "tasty", "bland"]', '["delicioso", "saboroso", "sem sabor"]');
