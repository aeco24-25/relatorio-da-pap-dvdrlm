-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 25, 2025 at 04:35 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `dteaches`
--

-- --------------------------------------------------------

--
-- Table structure for table `categoria`
--

CREATE TABLE `categoria` (
  `id_categoria` int(11) NOT NULL,
  `titulo` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `categoria`
--

INSERT INTO `categoria` (`id_categoria`, `titulo`) VALUES
(1, 'Saudações e Apresentações'),
(2, 'No Hotel'),
(3, 'Restaurantes e Alimentação'),
(4, 'Transportes'),
(5, 'Emergências'),
(6, 'Compras'),
(7, 'Direções e Localizações'),
(8, 'Trabalho e Negócios'),
(9, 'Tecnologia e Internet'),
(10, 'Lazer e Entretenimento');

-- --------------------------------------------------------

--
-- Table structure for table `exemplos`
--

CREATE TABLE `exemplos` (
  `id_exemplo` int(11) NOT NULL,
  `id_expressao` int(11) NOT NULL,
  `exemplo` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `exemplos`
--

INSERT INTO `exemplos` (`id_exemplo`, `id_expressao`, `exemplo`) VALUES
(1, 1, 'Hello, how are you? disse o colega quando me viu chegar.'),
(2, 2, 'Good morning, Dr. Silva! cumprimentou a enfermeira.'),
(3, 3, 'My name is Pedro apresentei-me aos novos colegas.'),
(4, 4, 'Nice to meet you, respondeu ela com um aperto de mão.'),
(5, 5, 'Where are you from? perguntou o taxista curioso.'),
(6, 6, 'Do you speak English? perguntei ao funcionário do museu.'),
(7, 7, 'I have a reservation under the name Oliveira disse ao rececionista.'),
(8, 8, 'What time is check-out? perguntei para planear a viagem.'),
(9, 9, 'Is breakfast included? queria saber se podia comer no hotel.'),
(10, 10, 'Do you have WiFi in the rooms? perguntei ao fazer check-in.'),
(11, 11, 'Liguei para a receção: The air conditioning is not working in room 304'),
(12, 12, 'Where is the elevator? perguntei com as malas pesadas.'),
(13, 13, 'A table for two, please pedimos ao maître.'),
(14, 14, 'Can I see the menu, please? pedi ao empregado.'),
(15, 15, 'I am vegetarian. Are there vegetarian options?'),
(16, 16, 'No final da refeição: Can I have the bill, please?'),
(17, 17, 'How spicy is this dish? I prefer mild food'),
(18, 18, 'Ao sair: It was delicious! Well come back!'),
(19, 19, '\"How do I get to the city center from here?\" perguntei ao polícia.'),
(20, 20, '\"Where is the nearest bus stop for line 28?\"'),
(21, 21, '\"I need a ticket to Porto, please\" disse na bilheteira.'),
(22, 22, '\"What time is the next train to Coimbra?\" verifiquei no painel.'),
(23, 23, '\"Is this the right bus for the shopping center?\" confirmei.'),
(24, 24, '\"How much is a taxi to the airport? Were four people\"'),
(25, 25, '\"Help! Someone call for help!\" gritei quando vi o acidente.'),
(26, 26, '\"I need a doctor, my friend has fainted\" disse desesperado.'),
(27, 27, '\"Call an ambulance, please! Its an emergency!\"'),
(28, 28, '\"Where is the nearest hospital with emergency care?\"'),
(29, 29, '\"I lost my passport and wallet on the tram\" reportei à polícia.'),
(30, 30, '\"Ive been robbed near the train station\"'),
(31, 31, '\"How much does this cost? Is there a discount for cash?\"'),
(32, 32, '\"Do you have this in a different size? Medium is too big\"'),
(33, 33, '\"Can I try it on? How many items can I take to the fitting room?\"'),
(34, 34, '\"Im just looking, thanks. Ill call if I need help\"'),
(35, 35, '\"Do you accept euros or only pounds?\" perguntei em Londres.'),
(36, 36, '\"Thats too expensive for my budget. Any similar but cheaper?\"'),
(37, 37, '\"Excuse me, where is the nearest ATM?\" perguntei a um transeunte.'),
(38, 38, '\"How far is it to the castle from here?\"'),
(39, 39, '\"Can you show me on the map? Im not from around here\"'),
(40, 40, '\"Turn left at the next traffic light, then right at the café\"'),
(41, 41, '\"Go straight ahead until you see the yellow building\"'),
(42, 42, '\"Its near the post office, next to the pastry shop\"'),
(43, 43, '\"I would like to schedule a meeting for next Wednesday\" disse ao assistente.'),
(44, 44, '\"When is the deadline for the project submission?\" perguntei ao colega.'),
(45, 45, '\"Could you send me the report by the end of the day?\" solicitei.'),
(46, 46, '\"I need to speak with the manager about the new contract\"'),
(47, 47, '\"Let me check my schedule and Ill get back to you\" respondi.'),
(48, 48, '\"The presentation is ready for tomorrows client meeting\"'),
(49, 49, '\"How do I connect to the WiFi? Whats the password?\" perguntei na receção.'),
(50, 50, '\"My password is not working even though Im sure its correct\"'),
(51, 51, '\"The website is not loading properly on my mobile device\"'),
(52, 52, '\"I forgot my username for this platform\" disse ao técnico de suporte.'),
(53, 53, '\"Where can I charge my phone? My battery is almost dead\"'),
(54, 54, '\"How do I update the app? It keeps crashing\"'),
(55, 55, '\"What are your hobbies?\" perguntou o novo colega durante o almoço.'),
(56, 56, '\"Do you want to go out tonight? Theres a new jazz club opening\"'),
(57, 57, '\"I love this song! Turn up the volume!\" disse no carro.'),
(58, 58, '\"What time does the concert start? We dont want to be late\"'),
(59, 59, '\"Are there any good museums here with contemporary art?\"'),
(60, 60, '\"Can you recommend a good movie for family night?\"');

-- --------------------------------------------------------

--
-- Table structure for table `exercicio_associacao`
--

CREATE TABLE `exercicio_associacao` (
  `id_exercicio` int(11) NOT NULL,
  `id_expressao` int(11) NOT NULL,
  `itens_ingles` text NOT NULL,
  `itens_portugues` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `exercicio_associacao`
--

INSERT INTO `exercicio_associacao` (`id_exercicio`, `id_expressao`, `itens_ingles`, `itens_portugues`) VALUES
(1, 3, '[\"My name is\", \"Hello\", \"Goodbye\"]', '[\"Chamo-me\", \"Olá\", \"Adeus\"]'),
(2, 6, '[\"Do you speak\", \"I understand\", \"I need\"]', '[\"Falas\", \"Compreendo\", \"Preciso\"]'),
(3, 9, '[\"breakfast\", \"WiFi\", \"pool\"]', '[\"pequeno-almoço\", \"internet\", \"piscina\"]'),
(4, 12, '[\"elevator\", \"room\", \"lobby\"]', '[\"elevador\", \"quarto\", \"recepção\"]'),
(5, 15, '[\"vegetarian\", \"vegan\", \"gluten-free\"]', '[\"vegetariano\", \"vegano\", \"sem glúten\"]'),
(6, 18, '[\"delicious\", \"tasty\", \"bland\"]', '[\"delicioso\", \"saboroso\", \"sem sabor\"]'),
(7, 21, '[\"ticket\", \"passport\", \"luggage\"]', '[\"bilhete\", \"passaporte\", \"bagagem\"]'),
(8, 24, '[\"taxi\", \"train\", \"bus\"]', '[\"táxi\", \"comboio\", \"autocarro\"]'),
(9, 27, '[\"ambulance\", \"police\", \"firefighter\"]', '[\"ambulância\", \"polícia\", \"bombeiro\"]'),
(10, 30, '[\"robbed\", \"lost\", \"found\"]', '[\"assaltado\", \"perdido\", \"encontrado\"]'),
(11, 33, '[\"try on\", \"buy\", \"return\"]', '[\"experimentar\", \"comprar\", \"devolver\"]'),
(12, 36, '[\"expensive\", \"cheap\", \"reasonable\"]', '[\"caro\", \"barato\", \"razoável\"]'),
(13, 39, '[\"map\", \"compass\", \"GPS\"]', '[\"mapa\", \"bússola\", \"GPS\"]'),
(14, 42, '[\"near\", \"far\", \"behind\"]', '[\"perto\", \"longe\", \"atrás\"]'),
(15, 45, '[\"report\", \"email\", \"attachment\"]', '[\"relatório\", \"email\", \"anexo\"]'),
(16, 48, '[\"presentation\", \"meeting\", \"agenda\"]', '[\"apresentação\", \"reunião\", \"agenda\"]'),
(17, 51, '[\"website\", \"app\", \"browser\"]', '[\"site\", \"aplicação\", \"navegador\"]'),
(18, 54, '[\"update\", \"download\", \"install\"]', '[\"atualizar\", \"descarregar\", \"instalar\"]'),
(19, 57, '[\"song\", \"music\", \"concert\"]', '[\"música\", \"música\", \"concerto\"]'),
(20, 60, '[\"movie\", \"theater\", \"ticket\"]', '[\"filme\", \"cinema\", \"bilhete\"]');

-- --------------------------------------------------------

--
-- Table structure for table `exercicio_preenchimento`
--

CREATE TABLE `exercicio_preenchimento` (
  `id_exercicio` int(11) NOT NULL,
  `id_expressao` int(11) NOT NULL,
  `texto_com_lacunas` text NOT NULL,
  `palavras_chave` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `exercicio_preenchimento`
--

INSERT INTO `exercicio_preenchimento` (`id_exercicio`, `id_expressao`, `texto_com_lacunas`, `palavras_chave`) VALUES
(1, 2, '______ morning! How are you today?', '[\"Good\"]'),
(2, 5, 'Where are you ______? I am from ______.', '[\"from\", \"Portugal\"]'),
(3, 8, 'What time is ______? The ______ is at 12:00.', '[\"check-out\", \"check-out\"]'),
(4, 11, 'The ______ conditioning is not ______. Can you fix it?', '[\"air\", \"working\"]'),
(5, 14, 'Can I see the ______, please? Here is our ______.', '[\"menu\", \"menu\"]'),
(6, 17, 'How ______ is this ______? Is it very spicy?', '[\"spicy\", \"dish\"]'),
(7, 20, 'Where is the nearest ______ stop? The ______ stop is around the corner.', '[\"bus\", \"bus\"]'),
(8, 23, 'Is this the ______ bus for the ______ center? Yes, it is.', '[\"right\", \"shopping\"]'),
(9, 26, 'I need a ______ urgently! My friend is having an ______ attack.', '[\"doctor\", \"asthma\"]'),
(10, 29, 'I lost my ______ and ______. What should I do?', '[\"passport\", \"wallet\"]'),
(11, 32, 'Do you have this in a different ______? I need a ______ size.', '[\"size\", \"smaller\"]'),
(12, 35, 'Do you accept ______? No, we only accept ______.', '[\"euros\", \"dollars\"]'),
(13, 38, 'How ______ is it to the ______? Its about 10 minutes walk.', '[\"far\", \"castle\"]'),
(14, 41, 'Go ______ ahead for about 200 ______, then turn right.', '[\"straight\", \"meters\"]'),
(15, 44, 'When is the ______ for this ______? Its next Friday.', '[\"deadline\", \"project\"]'),
(16, 47, 'Let me check my ______ and Ill ______ to you soon.', '[\"schedule\", \"get back\"]'),
(17, 50, 'My ______ is not working. Can you help me ______ it?', '[\"password\", \"reset\"]'),
(18, 53, 'Where can I ______ my ______? Theres a charging station over there.', '[\"charge\", \"phone\"]'),
(19, 56, 'Do you want to ______ out tonight? Theres a new ______ club opening.', '[\"go\", \"jazz\"]'),
(20, 59, 'Are there any good ______ here? Yes, the ______ of Modern Art is nearby.', '[\"museums\", \"Museum\"]');

-- --------------------------------------------------------

--
-- Table structure for table `expressoes`
--

CREATE TABLE `expressoes` (
  `id_expressao` int(11) NOT NULL,
  `versao_ingles` text NOT NULL,
  `traducao_portugues` text NOT NULL,
  `explicacao` text NOT NULL,
  `id_categoria` int(11) NOT NULL,
  `tipo_exercicio` enum('traducao','preenchimento','associacao') DEFAULT 'traducao'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `expressoes`
--

INSERT INTO `expressoes` (`id_expressao`, `versao_ingles`, `traducao_portugues`, `explicacao`, `id_categoria`, `tipo_exercicio`) VALUES
(1, 'Hello, how are you?', 'Olá, como estás?', 'Forma comum de cumprimentar alguém em inglês. Pode ser usado em qualquer situação, formal ou informal.', 1, 'traducao'),
(2, 'Good morning!', 'Bom dia!', 'Usado até aproximadamente meio-dia. Em situações formais, pode ser seguido pelo nome da pessoa.', 1, 'preenchimento'),
(3, 'My name is...', 'Chamo-me...', 'Frase essencial para se apresentar. Em contextos informais, pode-se usar apenas I am...', 1, 'associacao'),
(4, 'Nice to meet you!', 'Prazer em conhecer-te!', 'Usado quando se conhece alguém pela primeira vez. Em situações formais, pode-se dizer Pleased to meet you', 1, 'traducao'),
(5, 'Where are you from?', 'De onde és?', 'Pergunta comum em conversas iniciais. Resposta típica: I am from... seguido do país/cidade.', 1, 'preenchimento'),
(6, 'Do you speak English?', 'Falas inglês?', 'Pergunta útil quando não se tem certeza sobre o idioma do interlocutor.', 1, 'associacao'),
(7, 'I have a reservation', 'Tenho uma reserva', 'Frase essencial ao chegar ao hotel. Geralmente seguida pelo nome sob o qual a reserva foi feita.', 2, 'traducao'),
(8, 'What time is check-out?', 'A que horas é a saída?', 'Pergunta importante para planear a sua partida. A maioria dos hotéis tem check-out ao meio-dia.', 2, 'preenchimento'),
(9, 'Is breakfast included?', 'O pequeno-almoço está incluído?', 'Pergunta sobre serviços incluídos no preço. Alguns hotéis oferecem pequeno-almoço gratuito.', 2, 'associacao'),
(10, 'Do you have WiFi?', 'Têm internet sem fios?', 'Pergunta sobre internet disponível. Pode-se acrescentar Is it free? para saber se é gratuito.', 2, 'traducao'),
(11, 'The air conditioning is not working', 'O ar condicionado não está a funcionar', 'Frase para reportar problemas no quarto. Pode ser adaptada para outros problemas.', 2, 'preenchimento'),
(12, 'Where is the elevator?', 'Onde fica o elevador?', 'Pergunta sobre localização no hotel. Em inglês britânico diz-se lift.', 2, 'associacao'),
(13, 'A table for two, please', 'Uma mesa para dois, por favor', 'Pedido básico ao chegar ao restaurante. Substitua two pelo número de pessoas.', 3, 'traducao'),
(14, 'Can I see the menu, please?', 'Posso ver a ementa, por favor?', 'Pedido para ver o cardápio. Em alguns lugares o menu é chamado de bill of fare.', 3, 'preenchimento'),
(15, 'I am vegetarian', 'Sou vegetariano', 'Informação importante sobre restrições alimentares.', 3, 'associacao'),
(16, 'Can I have the bill, please?', 'Pode trazer a conta, por favor?', 'Pedido para pagar a conta. Nos EUA é comum dizer check.', 3, 'traducao'),
(17, 'How spicy is this dish?', 'Quão picante é este prato?', 'Pergunta importante para quem não tolera comida muito picante.', 3, 'preenchimento'),
(18, 'It was delicious!', 'Estava delicioso!', 'Elogio à comida. Pode usar The food was excellent.', 3, 'associacao'),
(19, 'How do I get to the city center?', 'Como chego ao centro da cidade?', 'Pergunta básica sobre direções. Pode substituir \"city center\" por qualquer outro local.', 4, 'traducao'),
(20, 'Where is the nearest bus stop?', 'Onde fica a paragem de autocarro mais próxima?', 'Pergunta sobre transporte público. Para \"metro\" use \"subway station\" (EUA) ou \"underground station\" (UK).', 4, 'preenchimento'),
(21, 'I need a ticket to...', 'Preciso de um bilhete para...', 'Frase para comprar passagens. Complete com o destino desejado.', 4, 'associacao'),
(22, 'What time is the next train?', 'A que horas é o próximo comboio?', 'Pergunta sobre horários. Para autocarro, substitua \"train\" por \"bus\".', 4, 'traducao'),
(23, 'Is this the right bus for...?', 'Este é o autocarro certo para...?', 'Pergunta para confirmar se está no veículo correto. Sempre verifique com o motorista.', 4, 'preenchimento'),
(24, 'How much is a taxi to the airport?', 'Quanto custa um táxi para o aeroporto?', 'Pergunta sobre preço de táxi. Algumas cidades têm tarifas fixas para o aeroporto.', 4, 'associacao'),
(25, 'Help!', 'Socorro!', 'Palavra universal para pedir ajuda em situações urgentes. Gritar para chamar atenção.', 5, 'traducao'),
(26, 'I need a doctor', 'Preciso de um médico', 'Frase essencial em emergências médicas. Pode acrescentar \"urgently\" para maior urgência.', 5, 'preenchimento'),
(27, 'Call an ambulance, please!', 'Chame uma ambulância, por favor!', 'Pedido para emergências médicas graves. Em Portugal disque 112.', 5, 'associacao'),
(28, 'Where is the nearest hospital?', 'Onde fica o hospital mais próximo?', 'Pergunta crucial em emergências. Pode usar \"pharmacy\" para farmácia de serviço.', 5, 'traducao'),
(29, 'I lost my passport', 'Perdi o meu passaporte', 'Frase para reportar documento perdido. Deve-se contactar também a embaixada.', 5, 'preenchimento'),
(30, 'I\'ve been robbed', 'Fui assaltado', 'Frase para reportar roubo à polícia. Pode usar \"My bag was stolen\" para itens específicos.', 5, 'associacao'),
(31, 'How much does this cost?', 'Quanto custa isto?', 'Pergunta básica sobre preço. Aponte para o item se não souber o nome em inglês.', 6, 'traducao'),
(32, 'Do you have this in a different size?', 'Tem isto noutro tamanho?', 'Pergunta sobre tamanhos disponíveis. Especifique \"smaller\" (menor) ou \"larger\" (maior).', 6, 'preenchimento'),
(33, 'Can I try it on?', 'Posso experimentar?', 'Pedido para provar roupas. Os provadores são chamados de \"fitting rooms\".', 6, 'associacao'),
(34, 'I\'m just looking, thanks', 'Estou só a ver, obrigado', 'Frase educada quando não quer comprar imediatamente. Útil para evitar pressão de vendedores.', 6, 'traducao'),
(35, 'Do you accept euros?', 'Aceitam euros?', 'Pergunta sobre moeda aceite. Fora da zona euro, muitas lojas aceitam euros com câmbio desfavorável.', 6, 'preenchimento'),
(36, 'That\'s too expensive', 'Isso é demasiado caro', 'Frase para negociar ou expressar que está acima do orçamento.', 6, 'associacao'),
(37, 'Excuse me, where is...?', 'Desculpe, onde fica...?', 'Forma educada de começar a pedir direções. Complete com o local que procura.', 7, 'traducao'),
(38, 'How far is it?', 'Fica muito longe?', 'Pergunta sobre distância. As respostas podem ser em metros ou minutos a pé.', 7, 'preenchimento'),
(39, 'Can you show me on the map?', 'Pode mostrar-me no mapa?', 'Pedido útil quando explicações verbais são confusas. Tenha um mapa ou app aberta.', 7, 'associacao'),
(40, 'Turn left/right', 'Vire à esquerda/direita', 'Instruções básicas de direção. \"Left\" é esquerda, \"right\" é direita.', 7, 'traducao'),
(41, 'Go straight ahead', 'Siga em frente', 'Instrução para continuar na mesma direção. Pode vir com \"for 200 meters\".', 7, 'preenchimento'),
(42, 'It\'s near/next to...', 'Fica perto/ao lado de...', 'Indicações usando pontos de referência. Útil quando o local não é muito conhecido.', 7, 'associacao'),
(43, 'I would like to schedule a meeting', 'Gostaria de marcar uma reunião', 'Frase formal para solicitar um encontro profissional. Pode especificar data/hora depois.', 8, 'traducao'),
(44, 'When is the deadline?', 'Quando é o prazo final?', 'Pergunta importante sobre prazos de projetos. Alternativa: \"What is the deadline for this?\"', 8, 'preenchimento'),
(45, 'Could you send me the report?', 'Pode enviar-me o relatório?', 'Pedido profissional comum. Pode adicionar \"by email\" para especificar o método.', 8, 'associacao'),
(46, 'I need to speak with the manager', 'Preciso de falar com o gerente', 'Frase para solicitar conversa com superior hierárquico.', 8, 'traducao'),
(47, 'Let me check my schedule', 'Deixe-me verificar a minha agenda', 'Resposta educada quando precisa de confirmar disponibilidade.', 8, 'preenchimento'),
(48, 'The presentation is ready', 'A apresentação está pronta', 'Informação importante antes de reuniões. Pode adicionar \"for the meeting\".', 8, 'associacao'),
(49, 'How do I connect to the WiFi?', 'Como me ligo à rede WiFi?', 'Pergunta essencial em hotéis, cafés e espaços públicos. Precisa do nome da rede e senha.', 9, 'traducao'),
(50, 'My password is not working', 'A minha palavra-passe não está a funcionar', 'Frase para reportar problemas de acesso. Pode precisar de \"reset password\".', 9, 'preenchimento'),
(51, 'The website is not loading', 'O site não está a carregar', 'Explicação comum para problemas técnicos. Alternativa: \"The page wont open\".', 9, 'associacao'),
(52, 'I forgot my username', 'Esqueci o meu nome de utilizador', 'Problema comum em plataformas online. Geralmente requer recuperação de conta.', 9, 'traducao'),
(53, 'Where can I charge my phone?', 'Onde posso carregar o telemóvel?', 'Pergunta prática em locais públicos. Pode especificar o tipo de carregador.', 9, 'preenchimento'),
(54, 'How do I update the app?', 'Como atualizo a aplicação?', 'Dúvida comum sobre manutenção de software. Alternativa: \"Check for updates\".', 9, 'associacao'),
(55, 'What are your hobbies?', 'Quais são os teus hobbies?', 'Pergunta comum em conversas sociais. Respostas típicas incluem atividades como ler, viajar, etc.', 10, 'traducao'),
(56, 'Do you want to go out tonight?', 'Queres sair esta noite?', 'Convite informal para atividades sociais. Pode especificar o local depois.', 10, 'preenchimento'),
(57, 'I love this song!', 'Adoro esta música!', 'Expressão de entusiasmo sobre música. Alternativa: \"This is my favorite song!\".', 10, 'associacao'),
(58, 'What time does the concert start?', 'A que horas começa o concerto?', 'Pergunta importante sobre eventos. Verifique também local e preços.', 10, 'traducao'),
(59, 'Are there any good museums here?', 'Há bons museus aqui?', 'Pergunta para explorar cultura local. Pode especificar tipo de museu.', 10, 'preenchimento'),
(60, 'Can you recommend a good movie?', 'Podes recomendar um bom filme?', 'Pedido de sugestão para entretenimento. Pode especificar o género.', 10, 'associacao');

-- --------------------------------------------------------

--
-- Table structure for table `progresso`
--

CREATE TABLE `progresso` (
  `username` varchar(20) NOT NULL,
  `id_expressao` int(11) NOT NULL,
  `completo` tinyint(1) DEFAULT 0,
  `data_conclusao` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `progresso`
--

INSERT INTO `progresso` (`username`, `id_expressao`, `completo`, `data_conclusao`) VALUES
('Duarte', 1, 1, '2025-04-24 21:32:18'),
('Duarte', 2, 1, '2025-04-24 21:32:22'),
('Duarte', 3, 1, '2025-04-24 21:32:37'),
('Duarte', 4, 1, '2025-04-24 21:32:39'),
('Duarte', 5, 1, '2025-04-24 21:33:36'),
('Duarte', 6, 1, '2025-04-24 21:33:42'),
('Duarte', 7, 1, '2025-04-23 15:47:57'),
('Duarte', 8, 1, '2025-04-23 16:00:30'),
('Duarte', 9, 1, '2025-04-23 16:24:14'),
('Duarte', 10, 1, '2025-04-23 21:48:22'),
('Duarte', 11, 1, '2025-04-23 22:37:10'),
('Duarte', 12, 1, '2025-04-23 22:37:18'),
('Duarte', 13, 1, '2025-04-24 21:33:50'),
('Duarte', 14, 1, '2025-04-24 21:34:01'),
('Duarte', 15, 1, '2025-04-24 21:34:07'),
('Duarte', 16, 1, '2025-04-24 21:34:12'),
('Duarte', 17, 1, '2025-04-24 21:34:29'),
('Duarte', 18, 1, '2025-04-24 21:34:47'),
('dvd', 1, 1, '2025-04-22 18:25:03'),
('dvd', 2, 1, '2025-04-22 18:25:08'),
('dvd', 3, 1, '2025-04-22 18:25:15'),
('dvd', 4, 1, '2025-04-22 18:25:19'),
('dvd', 5, 1, '2025-04-22 18:25:27'),
('dvd', 6, 1, '2025-04-22 18:25:39'),
('dvd', 7, 1, '2025-04-22 19:07:54'),
('dvd', 8, 1, '2025-04-22 19:08:28');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `username` varchar(20) NOT NULL,
  `email` varchar(50) NOT NULL,
  `pass` varchar(30) NOT NULL,
  `data_criacao` datetime DEFAULT current_timestamp(),
  `is_admin` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`username`, `email`, `pass`, `data_criacao`, `is_admin`) VALUES
('Duarte', 'duarte@gmail.com', 'Duarte123', '2025-04-23 12:49:43', 0),
('dvd', 'davidrolim704@gmail.com', 'David123', '2025-04-22 09:00:34', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `categoria`
--
ALTER TABLE `categoria`
  ADD PRIMARY KEY (`id_categoria`);

--
-- Indexes for table `exemplos`
--
ALTER TABLE `exemplos`
  ADD PRIMARY KEY (`id_exemplo`),
  ADD KEY `id_expressao` (`id_expressao`);

--
-- Indexes for table `exercicio_associacao`
--
ALTER TABLE `exercicio_associacao`
  ADD PRIMARY KEY (`id_exercicio`),
  ADD KEY `id_expressao` (`id_expressao`);

--
-- Indexes for table `exercicio_preenchimento`
--
ALTER TABLE `exercicio_preenchimento`
  ADD PRIMARY KEY (`id_exercicio`),
  ADD KEY `id_expressao` (`id_expressao`);

--
-- Indexes for table `expressoes`
--
ALTER TABLE `expressoes`
  ADD PRIMARY KEY (`id_expressao`),
  ADD KEY `id_categoria` (`id_categoria`);

--
-- Indexes for table `progresso`
--
ALTER TABLE `progresso`
  ADD PRIMARY KEY (`username`,`id_expressao`),
  ADD KEY `id_expressao` (`id_expressao`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `categoria`
--
ALTER TABLE `categoria`
  MODIFY `id_categoria` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `exemplos`
--
ALTER TABLE `exemplos`
  MODIFY `id_exemplo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=61;

--
-- AUTO_INCREMENT for table `exercicio_associacao`
--
ALTER TABLE `exercicio_associacao`
  MODIFY `id_exercicio` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `exercicio_preenchimento`
--
ALTER TABLE `exercicio_preenchimento`
  MODIFY `id_exercicio` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `expressoes`
--
ALTER TABLE `expressoes`
  MODIFY `id_expressao` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=61;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `exemplos`
--
ALTER TABLE `exemplos`
  ADD CONSTRAINT `exemplos_ibfk_1` FOREIGN KEY (`id_expressao`) REFERENCES `expressoes` (`id_expressao`);

--
-- Constraints for table `exercicio_associacao`
--
ALTER TABLE `exercicio_associacao`
  ADD CONSTRAINT `exercicio_associacao_ibfk_1` FOREIGN KEY (`id_expressao`) REFERENCES `expressoes` (`id_expressao`);

--
-- Constraints for table `exercicio_preenchimento`
--
ALTER TABLE `exercicio_preenchimento`
  ADD CONSTRAINT `exercicio_preenchimento_ibfk_1` FOREIGN KEY (`id_expressao`) REFERENCES `expressoes` (`id_expressao`);

--
-- Constraints for table `expressoes`
--
ALTER TABLE `expressoes`
  ADD CONSTRAINT `expressoes_ibfk_1` FOREIGN KEY (`id_categoria`) REFERENCES `categoria` (`id_categoria`);

--
-- Constraints for table `progresso`
--
ALTER TABLE `progresso`
  ADD CONSTRAINT `progresso_ibfk_1` FOREIGN KEY (`username`) REFERENCES `users` (`username`),
  ADD CONSTRAINT `progresso_ibfk_2` FOREIGN KEY (`id_expressao`) REFERENCES `expressoes` (`id_expressao`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
