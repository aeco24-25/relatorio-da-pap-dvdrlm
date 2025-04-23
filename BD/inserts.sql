USE dteaches;

INSERT INTO users (username, email, pass, is_admin) 
VALUES ('david', 'david@gmail.com', 'admin', TRUE);

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

-- =============================================
-- TRANSPORTES (6 expressões)
-- =============================================
INSERT INTO expressoes (versao_ingles, traducao_portugues, id_categoria, explicacao, tipo_exercicio) VALUES
('How do I get to the city center?', 'Como chego ao centro da cidade?', 4, 'Pergunta básica sobre direções. Pode substituir "city center" por qualquer outro local.', 'traducao'),
('Where is the nearest bus stop?', 'Onde fica a paragem de autocarro mais próxima?', 4, 'Pergunta sobre transporte público. Para "metro" use "subway station" (EUA) ou "underground station" (UK).', 'preenchimento'),
('I need a ticket to...', 'Preciso de um bilhete para...', 4, 'Frase para comprar passagens. Complete com o destino desejado.', 'associacao'),
('What time is the next train?', 'A que horas é o próximo comboio?', 4, 'Pergunta sobre horários. Para autocarro, substitua "train" por "bus".', 'traducao'),
('Is this the right bus for...?', 'Este é o autocarro certo para...?', 4, 'Pergunta para confirmar se está no veículo correto. Sempre verifique com o motorista.', 'preenchimento'),
('How much is a taxi to the airport?', 'Quanto custa um táxi para o aeroporto?', 4, 'Pergunta sobre preço de táxi. Algumas cidades têm tarifas fixas para o aeroporto.', 'associacao');

-- Exemplos para Transportes
INSERT INTO exemplos (id_expressao, exemplo) VALUES
(19, '"How do I get to the city center from here?" perguntei ao polícia.'),
(20, '"Where is the nearest bus stop for line 28?"'),
(21, '"I need a ticket to Porto, please" disse na bilheteira.'),
(22, '"What time is the next train to Coimbra?" verifiquei no painel.'),
(23, '"Is this the right bus for the shopping center?" confirmei.'),
(24, '"How much is a taxi to the airport? Were four people"');

-- Exercícios de preenchimento para Transportes
INSERT INTO exercicio_preenchimento (id_expressao, texto_com_lacunas, palavras_chave) VALUES
(20, 'Where is the nearest ______ stop? The ______ stop is around the corner.', '["bus", "bus"]'),
(23, 'Is this the ______ bus for the ______ center? Yes, it is.', '["right", "shopping"]');

-- Exercícios de associação para Transportes
INSERT INTO exercicio_associacao (id_expressao, itens_ingles, itens_portugues) VALUES
(21, '["ticket", "passport", "luggage"]', '["bilhete", "passaporte", "bagagem"]'),
(24, '["taxi", "train", "bus"]', '["táxi", "comboio", "autocarro"]');

-- =============================================
-- EMERGÊNCIAS (6 expressões)
-- =============================================
INSERT INTO expressoes (versao_ingles, traducao_portugues, id_categoria, explicacao, tipo_exercicio) VALUES
('Help!', 'Socorro!', 5, 'Palavra universal para pedir ajuda em situações urgentes. Gritar para chamar atenção.', 'traducao'),
('I need a doctor', 'Preciso de um médico', 5, 'Frase essencial em emergências médicas. Pode acrescentar "urgently" para maior urgência.', 'preenchimento'),
('Call an ambulance, please!', 'Chame uma ambulância, por favor!', 5, 'Pedido para emergências médicas graves. Em Portugal disque 112.', 'associacao'),
('Where is the nearest hospital?', 'Onde fica o hospital mais próximo?', 5, 'Pergunta crucial em emergências. Pode usar "pharmacy" para farmácia de serviço.', 'traducao'),
('I lost my passport', 'Perdi o meu passaporte', 5, 'Frase para reportar documento perdido. Deve-se contactar também a embaixada.', 'preenchimento'),
('I''ve been robbed', 'Fui assaltado', 5, 'Frase para reportar roubo à polícia. Pode usar "My bag was stolen" para itens específicos.', 'associacao');

-- Exemplos para Emergências
INSERT INTO exemplos (id_expressao, exemplo) VALUES
(25, '"Help! Someone call for help!" gritei quando vi o acidente.'),
(26, '"I need a doctor, my friend has fainted" disse desesperado.'),
(27, '"Call an ambulance, please! Its an emergency!"'),
(28, '"Where is the nearest hospital with emergency care?"'),
(29, '"I lost my passport and wallet on the tram" reportei à polícia.'),
(30, '"Ive been robbed near the train station"');

-- Exercícios de preenchimento para Emergências
INSERT INTO exercicio_preenchimento (id_expressao, texto_com_lacunas, palavras_chave) VALUES
(26, 'I need a ______ urgently! My friend is having an ______ attack.', '["doctor", "asthma"]'),
(29, 'I lost my ______ and ______. What should I do?', '["passport", "wallet"]');

-- Exercícios de associação para Emergências
INSERT INTO exercicio_associacao (id_expressao, itens_ingles, itens_portugues) VALUES
(27, '["ambulance", "police", "firefighter"]', '["ambulância", "polícia", "bombeiro"]'),
(30, '["robbed", "lost", "found"]', '["assaltado", "perdido", "encontrado"]');

-- =============================================
-- COMPRAS (6 expressões)
-- =============================================
INSERT INTO expressoes (versao_ingles, traducao_portugues, id_categoria, explicacao, tipo_exercicio) VALUES
('How much does this cost?', 'Quanto custa isto?', 6, 'Pergunta básica sobre preço. Aponte para o item se não souber o nome em inglês.', 'traducao'),
('Do you have this in a different size?', 'Tem isto noutro tamanho?', 6, 'Pergunta sobre tamanhos disponíveis. Especifique "smaller" (menor) ou "larger" (maior).', 'preenchimento'),
('Can I try it on?', 'Posso experimentar?', 6, 'Pedido para provar roupas. Os provadores são chamados de "fitting rooms".', 'associacao'),
('I''m just looking, thanks', 'Estou só a ver, obrigado', 6, 'Frase educada quando não quer comprar imediatamente. Útil para evitar pressão de vendedores.', 'traducao'),
('Do you accept euros?', 'Aceitam euros?', 6, 'Pergunta sobre moeda aceite. Fora da zona euro, muitas lojas aceitam euros com câmbio desfavorável.', 'preenchimento'),
('That''s too expensive', 'Isso é demasiado caro', 6, 'Frase para negociar ou expressar que está acima do orçamento.', 'associacao');

-- Exemplos para Compras
INSERT INTO exemplos (id_expressao, exemplo) VALUES
(31, '"How much does this cost? Is there a discount for cash?"'),
(32, '"Do you have this in a different size? Medium is too big"'),
(33, '"Can I try it on? How many items can I take to the fitting room?"'),
(34, '"Im just looking, thanks. Ill call if I need help"'),
(35, '"Do you accept euros or only pounds?" perguntei em Londres.'),
(36, '"Thats too expensive for my budget. Any similar but cheaper?"');

-- Exercícios de preenchimento para Compras
INSERT INTO exercicio_preenchimento (id_expressao, texto_com_lacunas, palavras_chave) VALUES
(32, 'Do you have this in a different ______? I need a ______ size.', '["size", "smaller"]'),
(35, 'Do you accept ______? No, we only accept ______.', '["euros", "dollars"]');

-- Exercícios de associação para Compras
INSERT INTO exercicio_associacao (id_expressao, itens_ingles, itens_portugues) VALUES
(33, '["try on", "buy", "return"]', '["experimentar", "comprar", "devolver"]'),
(36, '["expensive", "cheap", "reasonable"]', '["caro", "barato", "razoável"]');

-- =============================================
-- DIREÇÕES E LOCALIZAÇÕES (6 expressões)
-- =============================================
INSERT INTO expressoes (versao_ingles, traducao_portugues, id_categoria, explicacao, tipo_exercicio) VALUES
('Excuse me, where is...?', 'Desculpe, onde fica...?', 7, 'Forma educada de começar a pedir direções. Complete com o local que procura.', 'traducao'),
('How far is it?', 'Fica muito longe?', 7, 'Pergunta sobre distância. As respostas podem ser em metros ou minutos a pé.', 'preenchimento'),
('Can you show me on the map?', 'Pode mostrar-me no mapa?', 7, 'Pedido útil quando explicações verbais são confusas. Tenha um mapa ou app aberta.', 'associacao'),
('Turn left/right', 'Vire à esquerda/direita', 7, 'Instruções básicas de direção. "Left" é esquerda, "right" é direita.', 'traducao'),
('Go straight ahead', 'Siga em frente', 7, 'Instrução para continuar na mesma direção. Pode vir com "for 200 meters".', 'preenchimento'),
('It''s near/next to...', 'Fica perto/ao lado de...', 7, 'Indicações usando pontos de referência. Útil quando o local não é muito conhecido.', 'associacao');

-- Exemplos para Direções e Localizações
INSERT INTO exemplos (id_expressao, exemplo) VALUES
(37, '"Excuse me, where is the nearest ATM?" perguntei a um transeunte.'),
(38, '"How far is it to the castle from here?"'),
(39, '"Can you show me on the map? Im not from around here"'),
(40, '"Turn left at the next traffic light, then right at the café"'),
(41, '"Go straight ahead until you see the yellow building"'),
(42, '"Its near the post office, next to the pastry shop"');

-- Exercícios de preenchimento para Direções
INSERT INTO exercicio_preenchimento (id_expressao, texto_com_lacunas, palavras_chave) VALUES
(38, 'How ______ is it to the ______? Its about 10 minutes walk.', '["far", "castle"]'),
(41, 'Go ______ ahead for about 200 ______, then turn right.', '["straight", "meters"]');

-- Exercícios de associação para Direções
INSERT INTO exercicio_associacao (id_expressao, itens_ingles, itens_portugues) VALUES
(39, '["map", "compass", "GPS"]', '["mapa", "bússola", "GPS"]'),
(42, '["near", "far", "behind"]', '["perto", "longe", "atrás"]');

-- =============================================
-- TRABALHO E NEGÓCIOS (6 expressões)
-- =============================================
INSERT INTO expressoes (versao_ingles, traducao_portugues, id_categoria, explicacao, tipo_exercicio) VALUES
('I would like to schedule a meeting', 'Gostaria de marcar uma reunião', 8, 'Frase formal para solicitar um encontro profissional. Pode especificar data/hora depois.', 'traducao'),
('When is the deadline?', 'Quando é o prazo final?', 8, 'Pergunta importante sobre prazos de projetos. Alternativa: "What is the deadline for this?"', 'preenchimento'),
('Could you send me the report?', 'Pode enviar-me o relatório?', 8, 'Pedido profissional comum. Pode adicionar "by email" para especificar o método.', 'associacao'),
('I need to speak with the manager', 'Preciso de falar com o gerente', 8, 'Frase para solicitar conversa com superior hierárquico.', 'traducao'),
('Let me check my schedule', 'Deixe-me verificar a minha agenda', 8, 'Resposta educada quando precisa de confirmar disponibilidade.', 'preenchimento'),
('The presentation is ready', 'A apresentação está pronta', 8, 'Informação importante antes de reuniões. Pode adicionar "for the meeting".', 'associacao');

-- Exemplos para Trabalho e Negócios
INSERT INTO exemplos (id_expressao, exemplo) VALUES
(43, '"I would like to schedule a meeting for next Wednesday" disse ao assistente.'),
(44, '"When is the deadline for the project submission?" perguntei ao colega.'),
(45, '"Could you send me the report by the end of the day?" solicitei.'),
(46, '"I need to speak with the manager about the new contract"'),
(47, '"Let me check my schedule and Ill get back to you" respondi.'),
(48, '"The presentation is ready for tomorrows client meeting"');

-- Exercícios de preenchimento para Trabalho
INSERT INTO exercicio_preenchimento (id_expressao, texto_com_lacunas, palavras_chave) VALUES
(44, 'When is the ______ for this ______? Its next Friday.', '["deadline", "project"]'),
(47, 'Let me check my ______ and Ill ______ to you soon.', '["schedule", "get back"]');

-- Exercícios de associação para Trabalho
INSERT INTO exercicio_associacao (id_expressao, itens_ingles, itens_portugues) VALUES
(45, '["report", "email", "attachment"]', '["relatório", "email", "anexo"]'),
(48, '["presentation", "meeting", "agenda"]', '["apresentação", "reunião", "agenda"]');

-- =============================================
-- TECNOLOGIA E INTERNET (6 expressões)
-- =============================================
INSERT INTO expressoes (versao_ingles, traducao_portugues, id_categoria, explicacao, tipo_exercicio) VALUES
('How do I connect to the WiFi?', 'Como me ligo à rede WiFi?', 9, 'Pergunta essencial em hotéis, cafés e espaços públicos. Precisa do nome da rede e senha.', 'traducao'),
('My password is not working', 'A minha palavra-passe não está a funcionar', 9, 'Frase para reportar problemas de acesso. Pode precisar de "reset password".', 'preenchimento'),
('The website is not loading', 'O site não está a carregar', 9, 'Explicação comum para problemas técnicos. Alternativa: "The page wont open".', 'associacao'),
('I forgot my username', 'Esqueci o meu nome de utilizador', 9, 'Problema comum em plataformas online. Geralmente requer recuperação de conta.', 'traducao'),
('Where can I charge my phone?', 'Onde posso carregar o telemóvel?', 9, 'Pergunta prática em locais públicos. Pode especificar o tipo de carregador.', 'preenchimento'),
('How do I update the app?', 'Como atualizo a aplicação?', 9, 'Dúvida comum sobre manutenção de software. Alternativa: "Check for updates".', 'associacao');

-- Exemplos para Tecnologia e Internet
INSERT INTO exemplos (id_expressao, exemplo) VALUES
(49, '"How do I connect to the WiFi? Whats the password?" perguntei na receção.'),
(50, '"My password is not working even though Im sure its correct"'),
(51, '"The website is not loading properly on my mobile device"'),
(52, '"I forgot my username for this platform" disse ao técnico de suporte.'),
(53, '"Where can I charge my phone? My battery is almost dead"'),
(54, '"How do I update the app? It keeps crashing"');

-- Exercícios de preenchimento para Tecnologia
INSERT INTO exercicio_preenchimento (id_expressao, texto_com_lacunas, palavras_chave) VALUES
(50, 'My ______ is not working. Can you help me ______ it?', '["password", "reset"]'),
(53, 'Where can I ______ my ______? Theres a charging station over there.', '["charge", "phone"]');

-- Exercícios de associação para Tecnologia
INSERT INTO exercicio_associacao (id_expressao, itens_ingles, itens_portugues) VALUES
(51, '["website", "app", "browser"]', '["site", "aplicação", "navegador"]'),
(54, '["update", "download", "install"]', '["atualizar", "descarregar", "instalar"]');

-- =============================================
-- LAZER E ENTRETENIMENTO (6 expressões)
-- =============================================
INSERT INTO expressoes (versao_ingles, traducao_portugues, id_categoria, explicacao, tipo_exercicio) VALUES
('What are your hobbies?', 'Quais são os teus hobbies?', 10, 'Pergunta comum em conversas sociais. Respostas típicas incluem atividades como ler, viajar, etc.', 'traducao'),
('Do you want to go out tonight?', 'Queres sair esta noite?', 10, 'Convite informal para atividades sociais. Pode especificar o local depois.', 'preenchimento'),
('I love this song!', 'Adoro esta música!', 10, 'Expressão de entusiasmo sobre música. Alternativa: "This is my favorite song!".', 'associacao'),
('What time does the concert start?', 'A que horas começa o concerto?', 10, 'Pergunta importante sobre eventos. Verifique também local e preços.', 'traducao'),
('Are there any good museums here?', 'Há bons museus aqui?', 10, 'Pergunta para explorar cultura local. Pode especificar tipo de museu.', 'preenchimento'),
('Can you recommend a good movie?', 'Podes recomendar um bom filme?', 10, 'Pedido de sugestão para entretenimento. Pode especificar o género.', 'associacao');

-- Exemplos para Lazer e Entretenimento
INSERT INTO exemplos (id_expressao, exemplo) VALUES
(55, '"What are your hobbies?" perguntou o novo colega durante o almoço.'),
(56, '"Do you want to go out tonight? Theres a new jazz club opening"'),
(57, '"I love this song! Turn up the volume!" disse no carro.'),
(58, '"What time does the concert start? We dont want to be late"'),
(59, '"Are there any good museums here with contemporary art?"'),
(60, '"Can you recommend a good movie for family night?"');

-- Exercícios de preenchimento para Lazer
INSERT INTO exercicio_preenchimento (id_expressao, texto_com_lacunas, palavras_chave) VALUES
(56, 'Do you want to ______ out tonight? Theres a new ______ club opening.', '["go", "jazz"]'),
(59, 'Are there any good ______ here? Yes, the ______ of Modern Art is nearby.', '["museums", "Museum"]');

-- Exercícios de associação para Lazer
INSERT INTO exercicio_associacao (id_expressao, itens_ingles, itens_portugues) VALUES
(57, '["song", "music", "concert"]', '["música", "música", "concerto"]'),
(60, '["movie", "theater", "ticket"]', '["filme", "cinema", "bilhete"]');