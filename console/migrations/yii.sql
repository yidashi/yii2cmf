/*
Navicat MySQL Data Transfer

Source Server         : localhost
Source Server Version : 50536
Source Host           : 127.0.0.1:3306
Source Database       : yii

Target Server Type    : MYSQL
Target Server Version : 50536
File Encoding         : 65001

Date: 2015-11-27 19:01:21
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for pop_article
-- ----------------------------
DROP TABLE IF EXISTS `pop_article`;
CREATE TABLE `pop_article` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(50) NOT NULL,
  `content` text NOT NULL,
  `author` varchar(255) NOT NULL,
  `created_at` int(10) NOT NULL,
  `updated_at` int(10) NOT NULL,
  `status` tinyint(1) NOT NULL,
  `cover` varchar(255) DEFAULT NULL COMMENT '封面',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=674 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of pop_article
-- ----------------------------
INSERT INTO `pop_article` VALUES ('572', '老阴捉小鸡666666', '\n				<h1 class=\"title\">\n				</h1>\n<p>北上广不相信眼泪，江浙沪晒不干棉被，你在北方的艳阳里大雪纷飞，我在南方的阴雨里四季发霉。</p>\n				\n			', 'yidashi', '1448618886', '1448618886', '1', null);
INSERT INTO `pop_article` VALUES ('573', '你为我脱衣-我为你解裤', '\n				<h1 class=\"title\">\n				</h1>\n<p>到年底了，愁死我了，一出门就感觉自己少辆车，一看时间就感觉自己少块表，一拿起电话就感觉应该换个苹果6，一洗手就感觉少个钻戒，一穿衣服就感觉少件名牌，哎，原来自己啥都没有，最近缺钱不想露面，超过10块钱的活动，不要叫我，谁叫我。我跟谁急，我不是有钱任性，我是没钱认命</p>\n				\n			', 'yidashi', '1448618887', '1448618887', '1', null);
INSERT INTO `pop_article` VALUES ('574', 'Mustang77', '\n				<h1 class=\"title\">\n				</h1>\n<p>蓝翔学长曾对我说，就算挖穿了地球，也挖不到他迷失的心。 广场舞大妈曾对我说，如果跳的足够快，她的孤独就追不上她；拾荒大叔曾对我说，如果翻垃圾翻得足够仔细，便能找回丢失的自己</p>\n				\n			', 'yidashi', '1448618887', '1448618887', '1', null);
INSERT INTO `pop_article` VALUES ('575', '彡倾城丨薄凉人', '\n				<h1 class=\"title\">\n				</h1>\n<p>问：什么叫幸运？<br>答：从楼上掉下来，刚好下面有个草堆。<br>问：那什么叫不幸呢？<br>答：刚好草堆上有个叉子。<br>问：怎样是希望？<br>答：刚好你没掉在叉子上。<br>问：那怎样是绝望？<br>答：然而你也没掉在草堆上。。。</p>\n				\n			', 'yidashi', '1448618888', '1448618888', '1', null);
INSERT INTO `pop_article` VALUES ('576', '情书358575400', '\n				<h1 class=\"title\">\n				</h1>\n<p>小时候，和小伙伴一起去上学，走到一堵墙下，看见一头老母猪躺着那里晒太阳，那两排奶头真是显眼啊，我和小伙伴说，不知道猪奶好不好吃，那货说你试试，我真就趴上去吸了两口，后来……</p>\n				\n			', 'yidashi', '1448618889', '1448618889', '1', null);
INSERT INTO `pop_article` VALUES ('577', 'Mustang77', '\n				<h1 class=\"title\">\n				</h1>\n<p>姑姑的宝宝三个月了，母乳喂养的～ 今天和她逛街，走了一半宝宝饿了！ 她把宝宝塞给我说：“等一下！” 她就在原地跳了几下说：“好了！” 我表示不懂 ，她说：“喝前要先摇一摇！” 天雷滚滚啊～～～真想说不认识她！</p>\n				\n			', 'yidashi', '1448618890', '1448618890', '1', null);
INSERT INTO `pop_article` VALUES ('578', '脱下裤子笑嘻嘻', '\n				<h1 class=\"title\">\n				</h1>\n<p>单位一同事男喜欢喝绿茶，一天他一瓶绿茶喝一口就放桌上然后就出去办事去了，由于平时大家都爱往瓶里放烟头，等他事办完回来一口气就喝了一大半才发现味不对，当时我们所有人都看着他脸都绿了，又不能笑估计谁笑了他都会跟谁拼命，赶紧送医院吧……现在上厕所都还能拉出烟头来！</p>\n				\n			', 'yidashi', '1448618891', '1448618891', '1', null);
INSERT INTO `pop_article` VALUES ('579', 'JJ比蛋大', '\n				<h1 class=\"title\">\n				</h1>\n<p>今天走在街上一小孩对我吐口水，我不但没有骂他反而摸摸他的头说:真懂事！给了他5块钱，告诉他对别人也要这样。等我逛一圈回来看到他脸已经肿了。顿时…我觉得满满的全是正能量…！！</p>\n				\n			', 'yidashi', '1448618891', '1448618891', '1', null);
INSERT INTO `pop_article` VALUES ('580', '茈生37814759', '\n				<h1 class=\"title\">\n				</h1>\n<p>我今天做了一件特别无聊的事，我在路上走着走着我竟然犯傻的向空中吐了一口痰。然后我一个快步跳起来，一口接住了自己吐的痰，当时路人看我的眼神都惊呆。我当时真想找个洞自己钻进去了，真是羞死人了。</p>\n				\n			', 'yidashi', '1448618892', '1448618892', '1', null);
INSERT INTO `pop_article` VALUES ('581', 'Mustang77', '\n				<h1 class=\"title\">\n				</h1>\n<p>“145x154÷D2:1g” “什么意思？” “就是说你：一事无成 一无是处的2b一个！” “。。。。”</p>\n				\n			', 'yidashi', '1448618893', '1448618893', '1', null);
INSERT INTO `pop_article` VALUES ('582', '哎呀zzz妈呀', '\n				<h1 class=\"title\">\n				</h1>\n<p>很小的时候，每次在电视看排球比赛，我和我爸就赌穿什么颜色衣服的姑娘会赢，奇怪我每次都输给我爸。后来有一次，我问我爸：“爸爸，右上角那个「重播」是什么意思？”记得他当时说：“专心看比赛，再问以后就不跟你赌了。”</p>\n				\n			', 'yidashi', '1448618894', '1448618894', '1', null);
INSERT INTO `pop_article` VALUES ('583', '我就是隔壁还没成老王的小王', '\n				<h1 class=\"title\">\n				</h1>\n<p>教大家一个新技能，橘子中间挖个洞用温水泡一会……剩下的自己想吧</p>\n				\n			', 'yidashi', '1448618895', '1448618895', '1', null);
INSERT INTO `pop_article` VALUES ('584', '一马-赛-克', '\n				<h1 class=\"title\">\n				</h1>\n<p>一天同学聚会，都说自己工资有多高多高，问道我时我弱弱的很少的可怜就3000块。大家都笑话我说确实少的可怜，最后我补了句：老婆发的，全场瞬间沉默，然后惊呼：这才叫土豪啊。。。</p>\n				\n			', 'yidashi', '1448618895', '1448618895', '1', null);
INSERT INTO `pop_article` VALUES ('585', '糖糖糖油粑粑', '\n				<h1 class=\"title\">\n				</h1>\n<p>问一对男女：如果死后，在奈何桥看到孟 婆，给你喝孟婆汤，你说什么？女友：不要让 我忘掉亲人，好吗？男友：不要香菜和葱花， 谢谢！</p>\n				\n			', 'yidashi', '1448618896', '1448618896', '1', null);
INSERT INTO `pop_article` VALUES ('586', '不结果地花依然灿烂', '\n				<h1 class=\"title\">\n				</h1>\n<p>病人：医生，我的手指破了……医生看看：哦……说着拿起笔，唰唰，写好了，去吧，检查一下……病人：医生，不就是手破了吗？怎么要检查心电图？医生：啊呀，我说这人，没有听说过吗？十指连心……你不坚查，我能放心？</p>\n				\n			', 'yidashi', '1448618897', '1448618897', '1', null);
INSERT INTO `pop_article` VALUES ('587', 'Mustang77', '\n				<h1 class=\"title\">\n				</h1>\n<p>领导买了一箱牛奶放自己办公室，然后发现好几盒不见了。 中午吃饭时领导语重心长的说了这个事，希望偷喝的人能主动承认错误并还回来，末了加了一句：“其实箱子上是可以查到指纹的~” 等下午领导再回去，连箱子都不见了......</p>\n				\n			', 'yidashi', '1448618898', '1448618898', '1', null);
INSERT INTO `pop_article` VALUES ('588', '匿名用户', '\n				<h1 class=\"title\">\n				</h1>\n<p>王思聪在会议厅门口被一名女工作人员拦下，并被要求出示邀请函。王思聪戏谑地说“你拦我？”女人反问“你是谁？”王思聪一愣，继而紧紧抱住对方“我真没用！居然让你问出这样的问题。”</p>\n				\n			', 'yidashi', '1448618899', '1448618899', '1', null);
INSERT INTO `pop_article` VALUES ('589', '最红不过大姨妈-', '\n				<h1 class=\"title\">\n				</h1>\n<p>今天儿子老师请家长，我到老师办公室蒙了，这不是当年我的班主任吗？<br>他看到我也是一愣说：这是你儿子？我点点头。<br>老师叹了口气说：真是青出于蓝胜于蓝，当年你是在我椅子上，放图钉扎我！你儿子现在是在我走路时，双手合起来爆我菊花！！</p>\n				\n			', 'yidashi', '1448618899', '1448618899', '1', null);
INSERT INTO `pop_article` VALUES ('590', '魄56079591', '\n				<h1 class=\"title\">\n				</h1>\n<p>我拥有王思聪的屌丝，马云的脸，郭敬明的身高，还拥有韩红的身材，为什么就没有女朋友？</p>\n				\n			', 'yidashi', '1448618900', '1448618900', '1', null);
INSERT INTO `pop_article` VALUES ('591', '橘子洲头吃橘子', '\n				<h1 class=\"title\">\n				</h1>\n<p>姑娘：“大爷您坐！” 大爷：“姑娘你自己坐，你上班辛苦！我站一下没问题的！”<br>姑娘： “大爷您真好！” 大爷：“姑娘帮个忙，我钱掉了，腰不好你帮我捡一下。” 姑娘“给您大爷，哎呀大爷您不就掉了钱嘛，怎么流鼻血了，给你纸，快擦擦吧！”</p>\n				\n			', 'yidashi', '1448618901', '1448618901', '1', null);
INSERT INTO `pop_article` VALUES ('592', '1080p无码', '\n				<h1 class=\"title\">\n				</h1>\n<p>本人男，今天出门买零食想起家里的菜刀有点钝了就顺手买了一把菜刀。回家的时候路过小巷子，一女的惊慌的跑了过来，我看见后面的人就知道咋回事了。那人跑了过来恶狠狠的对我说：小子，不想死别多管闲事！说完掏出一把小军刀，还甩了两下，简直6的不行。看他表演完我默默的从塑料袋中拿出我那大菜刀...........</p>\n				\n			', 'yidashi', '1448618902', '1448618902', '1', null);
INSERT INTO `pop_article` VALUES ('593', '风与酒伴我走', '\n				<h1 class=\"title\">\n				</h1>\n<p>路上遇到一老人晕倒，马上将老人送医院，当时因身上没带多少钱于是打电话给女友，女友一进病房就骂到：“你脑子有病啊，管什么闲事！” 当她看到病床上的老人一惊：“爸！” 老人看了我女友一眼对我说：“小伙子，你人不错。听我一句话，和我女儿分手吧。</p>\n				\n			', 'yidashi', '1448618903', '1448618903', '1', null);
INSERT INTO `pop_article` VALUES ('594', 'S_筱霜', '\n				<h1 class=\"title\">\n				</h1>\n<p>晚上，我躺在床上刷段子，老公靠了过来吞吞吐吐的说道:“亲爱的老婆大人，那个……我想要……想要你……”我立马放下手机，兴奋的脱光衣服，摆出撩人的姿势:“死鬼～来呀～”老公:“给我20块钱买烟……”尼玛！“一分钟一块钱，你自己看着办！”</p>\n				\n			', 'yidashi', '1448618903', '1448618903', '1', null);
INSERT INTO `pop_article` VALUES ('595', 'Mustang77', '\n				<h1 class=\"title\">\n				</h1>\n<p>女孩问男孩“我和你妈一起掉进河里了，你先救谁？”男孩沉默不语，女孩生气的走了。 第二天再见到女孩，男孩手里拿了两套泳衣，说：“我教你游泳吧，到时候我们一起救我妈。 ”正当女孩把衣服脱下，准备换上泳衣时，男孩把她上了。。。</p>\n				\n			', 'yidashi', '1448618904', '1448618904', '1', null);
INSERT INTO `pop_article` VALUES ('596', '小西瓜IIII', '\n				<h1 class=\"title\">\n				</h1>\n<p>女朋友答应和我开房了，我好高兴！我就说先洗个鸳鸯浴，洗完之后给对方擦干，我顺手给她擦了把脸，擦完后！！！咱俩分手吧！以后别联系了</p>\n				\n			', 'yidashi', '1448618905', '1448618905', '1', null);
INSERT INTO `pop_article` VALUES ('597', '亲亲尓微笑', '\n				<h1 class=\"title\">\n				</h1>\n<p>我们中国的3000万光棍，可以考虑一些非洲的女人，光棍和他们结婚说不定生出的孩子聪明，因为离得远，而且非洲女人比较温顺，听话，国内女人太贵，要房要车的，屌丝们可以娶个非洲女人他们什么也不要。</p>\n				\n			', 'yidashi', '1448618906', '1448618906', '1', null);
INSERT INTO `pop_article` VALUES ('598', '半脸妆_晴儿', '\n				<h1 class=\"title\">\n				</h1>\n<p>一同事出轨被他老婆抓到证据了，于是大吵， 我们去劝架的时候，他老婆大声骂道：家里有狗粮你不吃，为什么偏偏要跑出去吃屎？？ 大家当场笑喷！喂喂喂…这是吵架现场严肃点行不？？</p>\n				\n			', 'yidashi', '1448618907', '1448618907', '1', null);
INSERT INTO `pop_article` VALUES ('599', '三胖大爷', '\n				<h1 class=\"title\">\n				</h1>\n<p>今天骑着自行车载着女友，半路车链子掉了，我下车蹲下来修理，狼狈不堪，这时一辆宝马停了下来，车窗摇下，里面正坐着我女友的前男友，他不屑地盯着我，笑着问我女友，你后悔么？女友微笑，淡淡地说，你爸爸给你的，我们以后也会有.只见女友的前男友脸色铁青，对我大吼道：爸，你听我后妈说话多气人!</p>\n				\n			', 'yidashi', '1448618907', '1448618907', '1', null);
INSERT INTO `pop_article` VALUES ('600', '独忍那滴泪', '\n				<h1 class=\"title\">\n				</h1>\n<p>国家通过二孩政策后，有天小明犯了错误，老师要见家长，小明说，父母不在家，让舅舅来可以不，老师说，那也行，结果第二天，小明抱着还不会走路的小舅来见老师，，，老师脸都绿了，说，抱着你的舅舅滚出去</p>\n				\n			', 'yidashi', '1448618908', '1448618908', '1', null);
INSERT INTO `pop_article` VALUES ('601', '我是你的小依赖9622716', '\n				<h1 class=\"title\">\n				</h1>\n<p>“老公，我刚刚被一个坏蛋给亲了”<br>“谁！”<br>“他拿一个棍子一样的东西插入了我的身体，搞得人家好痒”<br>“告诉我那孙子在哪，劳资要弄死他”<br>“不用你动手了，他已经被我给打死了”<br>“踏马的你打个蚊子都搞得那么销魂”</p>\n				\n			', 'yidashi', '1448618910', '1448618910', '1', null);
INSERT INTO `pop_article` VALUES ('602', '七秒锺记忆', '\n				<h1 class=\"title\">\n				</h1>\n<p>我有一个闺密，她养了只乌龟，从小到大，洗澡吃饭都在一起，基本属于青梅竹马两小无猜。那天她突然问我，乌龟是几岁成年啊？我一时答不上来，只听她悠悠的又来了一句：最近洗澡，发现它看我的眼神不太对……</p>\n				\n			', 'yidashi', '1448618910', '1448618910', '1', null);
INSERT INTO `pop_article` VALUES ('603', '偶尔犯浑', '\n				<h1 class=\"title\">\n				</h1>\n<p>“我可能要红了”。 一包被拆开的卫生巾哆嗦着对其他卫生巾说。</p>\n				\n			', 'yidashi', '1448618911', '1448618911', '1', null);
INSERT INTO `pop_article` VALUES ('604', 'Mustang77', '\n				<h1 class=\"title\">\n				</h1>\n<p>“你喜欢什么，我送给你。” “我喜欢玩偶，你买个给我吧。” “可以换个别的吗？” “怎么了？” “藕太粗了，伤身!”</p>\n				\n			', 'yidashi', '1448618912', '1448618912', '1', null);
INSERT INTO `pop_article` VALUES ('605', '萧十一次郎', '\n				<h1 class=\"title\">\n				</h1>\n<p>“被老公劈腿了怎么办？”发这么一句话，天涯的人会帮你把你老公劈腿的经历扒出来，猫扑会直接给你人肉出小三，知乎会告诉你应该首先了解什么行为叫做劈腿，贴吧会说无图无真相直接上照片好吗，豆瓣会陪你哭一会然后问你约吗，微博会把你的经历编成一堆段子，朋友圈会给你点一万个赞。</p>\n				\n			', 'yidashi', '1448618913', '1448618913', '1', null);
INSERT INTO `pop_article` VALUES ('606', '東萌西呆', '\n				<h1 class=\"title\">\n				</h1>\n<p>老婆在认识的时候就已经怀孕，她也没瞒我，我说不介意，我们就结婚了。后来有一次女儿生病，抽血化验的时候才发现女儿血型跟我一样，进一步做DNA化验，结果惊人地发现：她是我的亲生孩子！我一下子就懵了！让我想想。。。</p>\n				\n			', 'yidashi', '1448619764', '1448619764', '1', null);
INSERT INTO `pop_article` VALUES ('607', '老阴捉小鸡666666', '\n				<h1 class=\"title\">\n				</h1>\n<p>北上广不相信眼泪，江浙沪晒不干棉被，你在北方的艳阳里大雪纷飞，我在南方的阴雨里四季发霉。</p>\n				\n			', 'yidashi', '1448619765', '1448619765', '1', null);
INSERT INTO `pop_article` VALUES ('608', '你为我脱衣-我为你解裤', '\n				<h1 class=\"title\">\n				</h1>\n<p>到年底了，愁死我了，一出门就感觉自己少辆车，一看时间就感觉自己少块表，一拿起电话就感觉应该换个苹果6，一洗手就感觉少个钻戒，一穿衣服就感觉少件名牌，哎，原来自己啥都没有，最近缺钱不想露面，超过10块钱的活动，不要叫我，谁叫我。我跟谁急，我不是有钱任性，我是没钱认命</p>\n				\n			', 'yidashi', '1448619766', '1448619766', '1', null);
INSERT INTO `pop_article` VALUES ('609', 'Mustang77', '\n				<h1 class=\"title\">\n				</h1>\n<p>女孩问男孩“我和你妈一起掉进河里了，你先救谁？”男孩沉默不语，女孩生气的走了。 第二天再见到女孩，男孩手里拿了两套泳衣，说：“我教你游泳吧，到时候我们一起救我妈。 ”正当女孩把衣服脱下，准备换上泳衣时，男孩把她上了。。。</p>\n				\n			', 'yidashi', '1448619768', '1448619768', '1', null);
INSERT INTO `pop_article` VALUES ('610', 'Mustang77', '\n				<h1 class=\"title\">\n				</h1>\n<p>蓝翔学长曾对我说，就算挖穿了地球，也挖不到他迷失的心。 广场舞大妈曾对我说，如果跳的足够快，她的孤独就追不上她；拾荒大叔曾对我说，如果翻垃圾翻得足够仔细，便能找回丢失的自己</p>\n				\n			', 'yidashi', '1448619769', '1448619769', '1', null);
INSERT INTO `pop_article` VALUES ('611', '隔壁老痒', '\n				<h1 class=\"title\">\n				</h1>\n<p>刚才去楼下买水，刚掏出5块钱，一阵风刮跑了，到处没找到。于是我淡定的又掏出5块钱，故意扔掉，看看风往哪里刮。。。于是我丢了10块。</p>\n				\n			', 'yidashi', '1448619770', '1448619770', '1', null);
INSERT INTO `pop_article` VALUES ('612', '彡倾城丨薄凉人', '\n				<h1 class=\"title\">\n				</h1>\n<p>问：什么叫幸运？<br>答：从楼上掉下来，刚好下面有个草堆。<br>问：那什么叫不幸呢？<br>答：刚好草堆上有个叉子。<br>问：怎样是希望？<br>答：刚好你没掉在叉子上。<br>问：那怎样是绝望？<br>答：然而你也没掉在草堆上。。。</p>\n				\n			', 'yidashi', '1448619772', '1448619772', '1', null);
INSERT INTO `pop_article` VALUES ('613', '半脸妆_晴儿', '\n				<h1 class=\"title\">\n				</h1>\n<p>我妈为了让我多运动，把家里的网停了，拿我身份证到2公里外的网吧给我办了1000块的会员。每天晚上吃完饭没收车钥匙钱包就催我去玩，1个月瘦了5斤。比健身房效果好多了，亲妈。</p>\n				\n			', 'yidashi', '1448619773', '1448619773', '1', null);
INSERT INTO `pop_article` VALUES ('614', '情书358575400', '\n				<h1 class=\"title\">\n				</h1>\n<p>小时候，和小伙伴一起去上学，走到一堵墙下，看见一头老母猪躺着那里晒太阳，那两排奶头真是显眼啊，我和小伙伴说，不知道猪奶好不好吃，那货说你试试，我真就趴上去吸了两口，后来……</p>\n				\n			', 'yidashi', '1448619774', '1448619774', '1', null);
INSERT INTO `pop_article` VALUES ('615', 'Mustang77', '\n				<h1 class=\"title\">\n				</h1>\n<p>姑姑的宝宝三个月了，母乳喂养的～ 今天和她逛街，走了一半宝宝饿了！ 她把宝宝塞给我说：“等一下！” 她就在原地跳了几下说：“好了！” 我表示不懂 ，她说：“喝前要先摇一摇！” 天雷滚滚啊～～～真想说不认识她！</p>\n				\n			', 'yidashi', '1448619775', '1448619775', '1', null);
INSERT INTO `pop_article` VALUES ('616', '床上一抹红', '\n				<h1 class=\"title\">\n				</h1>\n<p>有一对夫妻，都是某农业大学高才生，结婚当天入洞房不知该怎么办，于是脱光衣服打开窗子等着小蜜蜂来传粉。</p>\n				\n			', 'yidashi', '1448619777', '1448619777', '1', null);
INSERT INTO `pop_article` VALUES ('617', '伊梦华胥_消沉', '\n				<h1 class=\"title\">\n				</h1>\n<p>我现在有3W块钱，800一个的充气娃娃买30个，是二万四，把房子稍微整修下，做个隔断。每个隔断放一个娃娃。一个娃娃的一天接客8次，一次三十元，就是240，三十个就是7200。这么说的话，我三天能回本，第四天开始盈利。一个月流水就是21万左右，一年就有将近240w。不出两年就能买车买房了。而且还不犯法。 想想就要走上人生巅峰了好激动……</p>\n				\n			', 'yidashi', '1448619779', '1448619779', '1', null);
INSERT INTO `pop_article` VALUES ('618', 'JJ比蛋大', '\n				<h1 class=\"title\">\n				</h1>\n<p>今天走在街上一小孩对我吐口水，我不但没有骂他反而摸摸他的头说:真懂事！给了他5块钱，告诉他对别人也要这样。等我逛一圈回来看到他脸已经肿了。顿时…我觉得满满的全是正能量…！！</p>\n				\n			', 'yidashi', '1448619781', '1448619781', '1', null);
INSERT INTO `pop_article` VALUES ('619', '茈生37814759', '\n				<h1 class=\"title\">\n				</h1>\n<p>我今天做了一件特别无聊的事，我在路上走着走着我竟然犯傻的向空中吐了一口痰。然后我一个快步跳起来，一口接住了自己吐的痰，当时路人看我的眼神都惊呆。我当时真想找个洞自己钻进去了，真是羞死人了。</p>\n				\n			', 'yidashi', '1448619783', '1448619783', '1', null);
INSERT INTO `pop_article` VALUES ('620', '我就是隔壁还没成老王的小王', '\n				<h1 class=\"title\">\n				</h1>\n<p>教大家一个新技能，橘子中间挖个洞用温水泡一会……剩下的自己想吧</p>\n				\n			', 'yidashi', '1448619784', '1448619784', '1', null);
INSERT INTO `pop_article` VALUES ('621', '哎呀zzz妈呀', '\n				<h1 class=\"title\">\n				</h1>\n<p>很小的时候，每次在电视看排球比赛，我和我爸就赌穿什么颜色衣服的姑娘会赢，奇怪我每次都输给我爸。后来有一次，我问我爸：“爸爸，右上角那个「重播」是什么意思？”记得他当时说：“专心看比赛，再问以后就不跟你赌了。”</p>\n				\n			', 'yidashi', '1448619786', '1448619786', '1', null);
INSERT INTO `pop_article` VALUES ('622', '隔壁老痒', '\n				<h1 class=\"title\">\n				</h1>\n<p>大学毕业后工作的地方离女友比较远，很长时间才能见一次面。今天又想去她那了，提前发了条短信给她：明儿我带我几亿兄弟去看你。 没过多久那边就信息回过来了: 那你要给你兄弟多准备几个收尸袋。</p>\n				\n			', 'yidashi', '1448619787', '1448619787', '1', null);
INSERT INTO `pop_article` VALUES ('623', '兔宝宝提莫6', '\n				<h1 class=\"title\">\n				</h1>\n<p>打LOL救了一残血妹子，死皮赖脸和我要QQ，然后就给了她了，现在她一直弹我视频，我一直不接，他就说我长帅，一直要和我处对象，还说我不好意思接视频，唉……我要不要告诉她我也是个妹子</p>\n				\n			', 'yidashi', '1448619788', '1448619788', '1', null);
INSERT INTO `pop_article` VALUES ('624', '一马-赛-克', '\n				<h1 class=\"title\">\n				</h1>\n<p>一天同学聚会，都说自己工资有多高多高，问道我时我弱弱的很少的可怜就3000块。大家都笑话我说确实少的可怜，最后我补了句：老婆发的，全场瞬间沉默，然后惊呼：这才叫土豪啊。。。</p>\n				\n			', 'yidashi', '1448619790', '1448619790', '1', null);
INSERT INTO `pop_article` VALUES ('625', '伊梦华胥_消沉', '\n				<h1 class=\"title\">\n				</h1>\n<p>在下姓聂，刚才到机场去接个客户，见面后客户非常热情的迎过来握手：聂总您好！您好！这时他的秘书用怪怪的目光在看我……<br>你妹啊！你才孽种，你全家都孽种！</p>\n				\n			', 'yidashi', '1448619791', '1448619791', '1', null);
INSERT INTO `pop_article` VALUES ('626', 'Mustang77', '\n				<h1 class=\"title\">\n				</h1>\n<p>领导买了一箱牛奶放自己办公室，然后发现好几盒不见了。 中午吃饭时领导语重心长的说了这个事，希望偷喝的人能主动承认错误并还回来，末了加了一句：“其实箱子上是可以查到指纹的~” 等下午领导再回去，连箱子都不见了......</p>\n				\n			', 'yidashi', '1448619792', '1448619792', '1', null);
INSERT INTO `pop_article` VALUES ('627', '匿名用户', '\n				<h1 class=\"title\">\n				</h1>\n<p>王思聪在会议厅门口被一名女工作人员拦下，并被要求出示邀请函。王思聪戏谑地说“你拦我？”女人反问“你是谁？”王思聪一愣，继而紧紧抱住对方“我真没用！居然让你问出这样的问题。”</p>\n				\n			', 'yidashi', '1448619793', '1448619793', '1', null);
INSERT INTO `pop_article` VALUES ('628', '最红不过大姨妈-', '\n				<h1 class=\"title\">\n				</h1>\n<p>今天儿子老师请家长，我到老师办公室蒙了，这不是当年我的班主任吗？<br>他看到我也是一愣说：这是你儿子？我点点头。<br>老师叹了口气说：真是青出于蓝胜于蓝，当年你是在我椅子上，放图钉扎我！你儿子现在是在我走路时，双手合起来爆我菊花！！</p>\n				\n			', 'yidashi', '1448619795', '1448619795', '1', null);
INSERT INTO `pop_article` VALUES ('629', '风与酒伴我走', '\n				<h1 class=\"title\">\n				</h1>\n<p>路上遇到一老人晕倒，马上将老人送医院，当时因身上没带多少钱于是打电话给女友，女友一进病房就骂到：“你脑子有病啊，管什么闲事！” 当她看到病床上的老人一惊：“爸！” 老人看了我女友一眼对我说：“小伙子，你人不错。听我一句话，和我女儿分手吧。</p>\n				\n			', 'yidashi', '1448619795', '1448619795', '1', null);
INSERT INTO `pop_article` VALUES ('630', '愿望18991784', '\n				<h1 class=\"title\">\n				</h1>\n<p>一位医学老前辈说，当了一辈子医生，最大收获是两大感悟：一是千万对自己的配偶要好，因为有一天，当你躺在病床上时，主宰你生命的不一定是医生，而是他/她，只有她有权签注“继续抢救”or“放弃治疗”；二是要对自己的师弟师妹后辈们要好，该传授的就要传授，不可以吝啬，因为迟早一天你会死于他们手上！</p>\n				\n			', 'yidashi', '1448619796', '1448619796', '1', null);
INSERT INTO `pop_article` VALUES ('631', 'Mustang77', '\n				<h1 class=\"title\">\n				</h1>\n<p>“你喜欢什么，我送给你。” “我喜欢玩偶，你买个给我吧。” “可以换个别的吗？” “怎么了？” “藕太粗了，伤身!”</p>\n				\n			', 'yidashi', '1448619798', '1448619798', '1', null);
INSERT INTO `pop_article` VALUES ('632', '一个人一座城59217399', '\n				<h1 class=\"title\">\n				</h1>\n<p>小时候最恶心的一件事。发高烧去看医生（农村的小诊所）。医生拿着温度计插进我腚内，过会儿拔出来观察了一下没有异常，甩了甩。叫我张开嘴，又插进我嘴里让我含着~~现在想想当时我脑子是不是坏掉了</p>\n				\n			', 'yidashi', '1448619800', '1448619800', '1', null);
INSERT INTO `pop_article` VALUES ('633', '三胖大爷', '\n				<h1 class=\"title\">\n				</h1>\n<p>今天骑着自行车载着女友，半路车链子掉了，我下车蹲下来修理，狼狈不堪，这时一辆宝马停了下来，车窗摇下，里面正坐着我女友的前男友，他不屑地盯着我，笑着问我女友，你后悔么？女友微笑，淡淡地说，你爸爸给你的，我们以后也会有.只见女友的前男友脸色铁青，对我大吼道：爸，你听我后妈说话多气人!</p>\n				\n			', 'yidashi', '1448619802', '1448619802', '1', null);
INSERT INTO `pop_article` VALUES ('634', '独忍那滴泪', '\n				<h1 class=\"title\">\n				</h1>\n<p>国家通过二孩政策后，有天小明犯了错误，老师要见家长，小明说，父母不在家，让舅舅来可以不，老师说，那也行，结果第二天，小明抱着还不会走路的小舅来见老师，，，老师脸都绿了，说，抱着你的舅舅滚出去</p>\n				\n			', 'yidashi', '1448619803', '1448619803', '1', null);
INSERT INTO `pop_article` VALUES ('635', '亲亲尓微笑', '\n				<h1 class=\"title\">\n				</h1>\n<p>我们中国的3000万光棍，可以考虑一些非洲的女人，光棍和他们结婚说不定生出的孩子聪明，因为离得远，而且非洲女人比较温顺，听话，国内女人太贵，要房要车的，屌丝们可以娶个非洲女人他们什么也不要。</p>\n				\n			', 'yidashi', '1448619805', '1448619805', '1', null);
INSERT INTO `pop_article` VALUES ('636', '我是你的小依赖9622716', '\n				<h1 class=\"title\">\n				</h1>\n<p>“老公，我刚刚被一个坏蛋给亲了”<br>“谁！”<br>“他拿一个棍子一样的东西插入了我的身体，搞得人家好痒”<br>“告诉我那孙子在哪，劳资要弄死他”<br>“不用你动手了，他已经被我给打死了”<br>“踏马的你打个蚊子都搞得那么销魂”</p>\n				\n			', 'yidashi', '1448619806', '1448619806', '1', null);
INSERT INTO `pop_article` VALUES ('637', '半脸妆_晴儿', '\n				<h1 class=\"title\">\n				</h1>\n<p>今天把小外甥给揍了！原因是这兔崽子趁我和他舅妈睡觉的时候，把被子掀了，而我媳妇有裸睡的习惯。那么多亲戚在我家做客，让我媳妇以后怎么见人！大伙可能认为小孩子不懂事，应该原谅。可这小崽子把我媳妇气给放了我忍不了了！！！！</p>\n				\n			', 'yidashi', '1448619808', '1448619808', '1', null);
INSERT INTO `pop_article` VALUES ('638', '鹰的高度豹的速度', '\n				<h1 class=\"title\">\n				</h1>\n<p>感觉媳妇是真心对我好！昨夜双十一在淘宝抢购65件物品，虽然花点了我四万多但心里是暖的。抢购的65件物品中有64件都是买给我的。有我的袜子，内裤，还买了N多包我最喜欢吃的薯片。她就给自己买了一个包39280元！好感动啊。</p>\n				\n			', 'yidashi', '1448619809', '1448619809', '1', null);
INSERT INTO `pop_article` VALUES ('639', '不结果地花依然灿烂', '\n				<h1 class=\"title\">\n				</h1>\n<p>病人：医生，我的手指破了……医生看看：哦……说着拿起笔，唰唰，写好了，去吧，检查一下……病人：医生，不就是手破了吗？怎么要检查心电图？医生：啊呀，我说这人，没有听说过吗？十指连心……你不坚查，我能放心？</p>\n				\n			', 'yidashi', '1448619811', '1448619811', '1', null);
INSERT INTO `pop_article` VALUES ('640', '无证斋', '\n				<h1 class=\"title\">\n				</h1>\n<p>老婆在认识的时候就已经怀孕，她也没瞒我，我说不介意，我们就结婚了。后来有一次孩子生病，抽血化验的时候才发现孩子血型跟我一样，进一步做DNA化验，结果惊人地发现：他是我的亲生孩子！……一下子就懵了！……让我想想……</p>\n				\n			', 'yidashi', '1448619813', '1448619813', '1', null);
INSERT INTO `pop_article` VALUES ('641', '__阿徽', '\n				<h1 class=\"title\">\n				</h1>\n<p>一天去医院输液，一个护士过来给我化验抽血，我突然想起一个段子，于是装作不懂的样子，问到，这绑在我胳膊上的皮筋是啥啊，护士答：压脉带。我：什么啊，护士急：压脉带，压脉带</p>\n				\n			', 'yidashi', '1448619814', '1448619814', '1', null);
INSERT INTO `pop_article` VALUES ('642', '开拓19190480', '\n				<h1 class=\"title\">\n				</h1>\n<p>今天约妹子去KFC吃饭，点了好多，正吃着，我问妹子可不可以做我女朋友，她正吃鸡翅，听完抬起头问我说如果我说不可以那我还能不能吃了。我，，，，</p>\n				\n			', 'yidashi', '1448619816', '1448619816', '1', null);
INSERT INTO `pop_article` VALUES ('643', '匿名用户', '\n				<h1 class=\"title\">\n				</h1>\n<p>中国队进入世界杯只需5步：<br>1.通过运作，让国际足联分配给南极洲一个名额。<br>2.中国男足被分到南极洲赛区。<br>3.中国男足和企鹅争夺出线权。<br>4.客场逼平企鹅；<br>5.主场安排在三亚，热死企鹅后直接出线。<br>按目前实际来看，这五步走计划的唯一难点在4。</p>\n				\n			', 'yidashi', '1448619817', '1448619817', '1', null);
INSERT INTO `pop_article` VALUES ('644', '飞翔的糖豆', '\n				<h1 class=\"title\">\n				</h1>\n<p>肚子一阵剧痛，抓起手机和香烟就往厕所跑，一阵倾泻，好舒服啊！突然发现，马丹，少了样东西，我该咋办呢！</p>\n				\n			', 'yidashi', '1448619818', '1448619818', '1', null);
INSERT INTO `pop_article` VALUES ('645', 'Mustang77', '\n				<h1 class=\"title\">\n				</h1>\n<p>女孩问男孩“我和你妈一起掉进河里了，你先救谁？”男孩沉默不语，女孩生气的走了。 第二天再见到女孩，男孩手里拿了两套泳衣，说：“我教你游泳吧，到时候我们一起救我妈。 ”正当女孩把衣服脱下，准备换上泳衣时，男孩把她上了。。。</p>\n				\n			', 'yidashi', '1448619818', '1448619818', '1', null);
INSERT INTO `pop_article` VALUES ('646', '梦中捞月', '\n				<h1 class=\"title\">\n				</h1>\n<p>伊拉克那年拿亚洲冠军，但国家被美帝干出翔。意大利拿完世冠，经济就崩了。希腊那年拿了欧洲杯，然后就破产。德国拿完世界杯，难民潮就来了。北宋刚发现世界巨星高俅，皇帝就让金国抓了。明白了吧？那么多年来，一直忍辱负重，守护国运，让中国稳定发展的护国法师是谁？大声喊出四个字:中国男足</p>\n				\n			', 'yidashi', '1448619819', '1448619819', '1', null);
INSERT INTO `pop_article` VALUES ('647', '情迷LasVegass', '\n				<h1 class=\"title\">\n				</h1>\n<p>中国媳妇五大酷刑：<br>第五名：跪搓衣板，一小时起步<br>第四名：跪方便面，方便面不能碎，起步10分钟，每碎一粒加5分钟，<br>第三名：跪遥控器，对着电视跪不能换台<br>第二名：跪电子秤，媳妇说几斤几两就跪几斤几两<br>第一名：跪蚂蚁，不能让蚂蚁跑了，也不能让蚂蚁死了<br>还有些啥花样欢迎补充</p>\n				\n			', 'yidashi', '1448619820', '1448619820', '1', null);
INSERT INTO `pop_article` VALUES ('648', 'Mustang77', '\n				<h1 class=\"title\">\n				</h1>\n<p>以后只要是我的朋友，谁没钱了，尽管和我说一声，只要我有空，就可以给你讲讲没钱的时候我是怎么度过的……</p>\n				\n			', 'yidashi', '1448619821', '1448619821', '1', null);
INSERT INTO `pop_article` VALUES ('649', 'Mustang77', '\n				<h1 class=\"title\">\n				</h1>\n<p>姑姑的宝宝三个月了，母乳喂养的～ 今天和她逛街，走了一半宝宝饿了！ 她把宝宝塞给我说：“等一下！” 她就在原地跳了几下说：“好了！” 我表示不懂 ，她说：“喝前要先摇一摇！” 天雷滚滚啊～～～真想说不认识她！</p>\n				\n			', 'yidashi', '1448619821', '1448619821', '1', null);
INSERT INTO `pop_article` VALUES ('650', '床上一抹红', '\n				<h1 class=\"title\">\n				</h1>\n<p>有一对夫妻，都是某农业大学高才生，结婚当天入洞房不知该怎么办，于是脱光衣服打开窗子等着小蜜蜂来传粉。</p>\n				\n			', 'yidashi', '1448619822', '1448619822', '1', null);
INSERT INTO `pop_article` VALUES ('651', '姑娘别装哥看不见', '\n				<h1 class=\"title\">\n				</h1>\n<p>女：亲爱的，我们取个情侣网名吧！<br>男：好啊！<br>女：我就叫忧伤，你看着办吧。<br>男：那我就叫风。<br>女：风和忧伤有什么关系？<br>男：“昨天遗忘，风干了忧伤。”</p>\n				\n			', 'yidashi', '1448619823', '1448619823', '1', null);
INSERT INTO `pop_article` VALUES ('652', '伊梦华胥_消沉', '\n				<h1 class=\"title\">\n				</h1>\n<p>我现在有3W块钱，800一个的充气娃娃买30个，是二万四，把房子稍微整修下，做个隔断。每个隔断放一个娃娃。一个娃娃的一天接客8次，一次三十元，就是240，三十个就是7200。这么说的话，我三天能回本，第四天开始盈利。一个月流水就是21万左右，一年就有将近240w。不出两年就能买车买房了。而且还不犯法。 想想就要走上人生巅峰了好激动……</p>\n				\n			', 'yidashi', '1448619824', '1448619824', '1', null);
INSERT INTO `pop_article` VALUES ('653', '伊梦华胥_消沉', '\n				<h1 class=\"title\">\n				</h1>\n<p>高中的时候，放学回家需要经过一条山路。一天路上肚子疼，看看四下无人，就脱下裤子在路边拉翔。 忽然弯道上走来一个女同学，情急之下，我撅着腚溜上了陡坡在草丛里藏了起来。正紧张着，特么坡顶上突然滚下来一只打架的山羊，巨大的撞击下，我和那只羊一齐从山坡滚到了路边，女同学突然看到我光着屁股还抱着一只羊，惊叫一声赶紧跑了…… 后来我操山羊的消息在学校传开了。。。。</p>\n				\n			', 'yidashi', '1448619825', '1448619825', '1', null);
INSERT INTO `pop_article` VALUES ('654', '人潮24334842', '\n				<h1 class=\"title\">\n				</h1>\n<p>老婆摸摸七个月的肚子对我说：该给你孩子娶个名了。<br>我说：你名字里面有个香，你是我最珍爱的人，就叫珍香吧<br>老婆啪就是一嘴巴：提莫的忘了你姓史吗？</p>\n				\n			', 'yidashi', '1448619825', '1448619825', '1', null);
INSERT INTO `pop_article` VALUES ('655', '我就是隔壁还没成老王的小王', '\n				<h1 class=\"title\">\n				</h1>\n<p>教大家一个新技能，橘子中间挖个洞用温水泡一会……剩下的自己想吧</p>\n				\n			', 'yidashi', '1448619826', '1448619826', '1', null);
INSERT INTO `pop_article` VALUES ('656', '隔壁老痒', '\n				<h1 class=\"title\">\n				</h1>\n<p>大学毕业后工作的地方离女友比较远，很长时间才能见一次面。今天又想去她那了，提前发了条短信给她：明儿我带我几亿兄弟去看你。 没过多久那边就信息回过来了: 那你要给你兄弟多准备几个收尸袋。</p>\n				\n			', 'yidashi', '1448619827', '1448619827', '1', null);
INSERT INTO `pop_article` VALUES ('657', '半脸妆_晴儿', '\n				<h1 class=\"title\">\n				</h1>\n<p>喝最多那次是八年前，醉的诡异又凄凉。醒来发现在一张窄小的床上，床很古怪，特别高。床底下有人聊天。口音更古怪，一句都听不懂。床边有扇窗，窗外是旷野，见不到一个人。问床底下聊天的这是那？那人用蹩脚普通话说过宜宾了，我当时彻底崩了，操他妈不知道哪个混蛋趁我喝多把我塞上火车了</p>\n				\n			', 'yidashi', '1448619828', '1448619828', '1', null);
INSERT INTO `pop_article` VALUES ('658', 'Mustang77', '\n				<h1 class=\"title\">\n				</h1>\n<p>今天看见女神QQ在线很激动的问：＂在嘛？＂一会女神回复：＂在拉，什么事？＂我激动半天女神居然回了，我说：＂那你先拉，拉完我们在聊＂。结果等半天女神也没拉好</p>\n				\n			', 'yidashi', '1448619829', '1448619829', '1', null);
INSERT INTO `pop_article` VALUES ('659', 'Mustang77', '\n				<h1 class=\"title\">\n				</h1>\n<p>一天老板开会说到：咱们单位员工一定要团结，我们好比一个键盘，所有的的人都好比按键，一个萝卜一个坑、都是不可缺少的。我就挑逗的说到：那老板我是什么按键那？老板说：你就像F7，占个地方，到现在我都不知道你能干什么用！</p>\n				\n			', 'yidashi', '1448619829', '1448619829', '1', null);
INSERT INTO `pop_article` VALUES ('660', '用户62542862', '\n				<h1 class=\"title\">\n				</h1>\n<p>我上小学的时候，姐姐经常用灌了水的气球丢我，一到夏天，我全身老是水淋淋的，一回家就被母亲呵斥。后来我实在忍不下去了，便偷偷把每个气球上都扎了眼儿，终于逃脱了每日水灾。第二年的夏天，我妹妹诞生了。</p>\n				\n			', 'yidashi', '1448619830', '1448619830', '1', null);
INSERT INTO `pop_article` VALUES ('661', '黄埔云儿', '\n				<h1 class=\"title\">\n				</h1>\n<p>一天早上，我正准备起床，他趴在我的身上，慵懒的对我说:再陪我们睡一会吧。另一个在背后揽住我的脖子也附和道:是呀，再陪我们一会吧。<br>在这深冬，有他们的陪伴，多么幸福啊。还是被子和枕头对我好啊...</p>\n				\n			', 'yidashi', '1448619831', '1448619831', '1', null);
INSERT INTO `pop_article` VALUES ('662', '蹦傻噶啦哈', '\n				<h1 class=\"title\">\n				</h1>\n<p>我刚买的苹果6不小心掉水了，吓得我赶紧把电池扣下来 用吹风机吹干，这不刚安上电池就来发段子了么，行货 质量就是好，</p>\n				\n			', 'yidashi', '1448619832', '1448619832', '1', null);
INSERT INTO `pop_article` VALUES ('663', 'Mustang77', '\n				<h1 class=\"title\">\n				</h1>\n<p>“你喜欢什么，我送给你。” “我喜欢玩偶，你买个给我吧。” “可以换个别的吗？” “怎么了？” “藕太粗了，伤身!”</p>\n				\n			', 'yidashi', '1448619832', '1448619832', '1', null);
INSERT INTO `pop_article` VALUES ('664', '魄56079591', '\n				<h1 class=\"title\">\n				</h1>\n<p>我拥有王思聪的屌丝，马云的脸，郭敬明的身高，还拥有韩红的身材，为什么就没有女朋友？</p>\n				\n			', 'yidashi', '1448619833', '1448619833', '1', null);
INSERT INTO `pop_article` VALUES ('665', '愿望18991784', '\n				<h1 class=\"title\">\n				</h1>\n<p>一位医学老前辈说，当了一辈子医生，最大收获是两大感悟：一是千万对自己的配偶要好，因为有一天，当你躺在病床上时，主宰你生命的不一定是医生，而是他/她，只有她有权签注“继续抢救”or“放弃治疗”；二是要对自己的师弟师妹后辈们要好，该传授的就要传授，不可以吝啬，因为迟早一天你会死于他们手上！</p>\n				\n			', 'yidashi', '1448619834', '1448619834', '1', null);
INSERT INTO `pop_article` VALUES ('666', '李军64088128', '\n				<h1 class=\"title\">\n				</h1>\n<p>一哥们连住通了几天宵，又饿又困，便去一家饭馆要了份盖饭，吃着吃着这哥们就睡着了，一头栽在了盘子里，这时候旁边一哥们愣了下，大声喊到：我艹尼玛，这饭里面有毒！</p>\n				\n			', 'yidashi', '1448619835', '1448619835', '1', null);
INSERT INTO `pop_article` VALUES ('667', '慢热房客', '\n				<h1 class=\"title\">\n				</h1>\n<p>今天跟一妹子下象棋，你说你马有三条命我忍了，你的象可以过河是小飞象我忍了，车可以拐弯是碰碰车我也忍了，但你用我的士干掉我的将还说是你培养的间谍几个意思</p>\n				\n			', 'yidashi', '1448619835', '1448619835', '1', null);
INSERT INTO `pop_article` VALUES ('668', '亲亲尓微笑', '\n				<h1 class=\"title\">\n				</h1>\n<p>我们中国的3000万光棍，可以考虑一些非洲的女人，光棍和他们结婚说不定生出的孩子聪明，因为离得远，而且非洲女人比较温顺，听话，国内女人太贵，要房要车的，屌丝们可以娶个非洲女人他们什么也不要。</p>\n				\n			', 'yidashi', '1448619836', '1448619836', '1', null);
INSERT INTO `pop_article` VALUES ('669', '我是你的小依赖9622716', '\n				<h1 class=\"title\">\n				</h1>\n<p>“老公，我刚刚被一个坏蛋给亲了”<br>“谁！”<br>“他拿一个棍子一样的东西插入了我的身体，搞得人家好痒”<br>“告诉我那孙子在哪，劳资要弄死他”<br>“不用你动手了，他已经被我给打死了”<br>“踏马的你打个蚊子都搞得那么销魂”</p>\n				\n			', 'yidashi', '1448619837', '1448619837', '1', null);
INSERT INTO `pop_article` VALUES ('670', '七秒锺记忆', '\n				<h1 class=\"title\">\n				</h1>\n<p>我有一个闺密，她养了只乌龟，从小到大，洗澡吃饭都在一起，基本属于青梅竹马两小无猜。那天她突然问我，乌龟是几岁成年啊？我一时答不上来，只听她悠悠的又来了一句：最近洗澡，发现它看我的眼神不太对……</p>\n				\n			', 'yidashi', '1448619837', '1448619837', '1', null);
INSERT INTO `pop_article` VALUES ('671', 'Mustang77', '\n				<h1 class=\"title\">\n				</h1>\n<p>今天早上晨跑，看到前面两妹子，感觉跑不动的样子。 我鼓起勇气上前搭讪：“嗨，美女怎么不跑了？” 美女：“累了，跑不动了。” 我摸了她的胸部，撒腿就跑。</p>\n				\n			', 'yidashi', '1448619838', '1448619838', '1', null);
INSERT INTO `pop_article` VALUES ('672', '最好的满足是你给的在乎10797253', '\n				<h1 class=\"title\">\n				</h1>\n<p>在超市被人插队已是常见之事，以前或许还会争吵或动手，如今上了年纪了，稳重了，不再像以前那么冲动了，就像之前。一个带着上了高中的女儿还要插我队的妇人，我微笑着走开了，换了一个通道，只是临走时随手把一盒杰士邦塞进小姑娘的书包里--报警的钟声响起，对后面的故事我已不感兴趣了！</p>\n				\n			', 'yidashi', '1448619839', '1448619839', '1', null);
INSERT INTO `pop_article` VALUES ('673', '鹰的高度豹的速度', '\n				<h1 class=\"title\">\n				</h1>\n<p>感觉媳妇是真心对我好！昨夜双十一在淘宝抢购65件物品，虽然花点了我四万多但心里是暖的。抢购的65件物品中有64件都是买给我的。有我的袜子，内裤，还买了N多包我最喜欢吃的薯片。她就给自己买了一个包39280元！好感动啊。</p>\n				\n			', 'yidashi', '1448619840', '1448619840', '1', null);

-- ----------------------------
-- Table structure for pop_auth_assignment
-- ----------------------------
DROP TABLE IF EXISTS `pop_auth_assignment`;
CREATE TABLE `pop_auth_assignment` (
  `item_name` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `user_id` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`item_name`,`user_id`),
  CONSTRAINT `pop_auth_assignment_ibfk_1` FOREIGN KEY (`item_name`) REFERENCES `pop_auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of pop_auth_assignment
-- ----------------------------
INSERT INTO `pop_auth_assignment` VALUES ('author', '2', '1443080982');
INSERT INTO `pop_auth_assignment` VALUES ('superAdmin', '1', '1443080982');

-- ----------------------------
-- Table structure for pop_auth_item
-- ----------------------------
DROP TABLE IF EXISTS `pop_auth_item`;
CREATE TABLE `pop_auth_item` (
  `name` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `type` int(11) NOT NULL,
  `description` text COLLATE utf8_unicode_ci,
  `rule_name` varchar(64) COLLATE utf8_unicode_ci DEFAULT NULL,
  `data` text COLLATE utf8_unicode_ci,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`name`),
  KEY `rule_name` (`rule_name`),
  KEY `idx-auth_item-type` (`type`),
  CONSTRAINT `pop_auth_item_ibfk_1` FOREIGN KEY (`rule_name`) REFERENCES `pop_auth_rule` (`name`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of pop_auth_item
-- ----------------------------
INSERT INTO `pop_auth_item` VALUES ('/*', '2', null, null, null, '1443338692', '1443338692');
INSERT INTO `pop_auth_item` VALUES ('/admin/*', '2', null, null, null, '1443338692', '1443338692');
INSERT INTO `pop_auth_item` VALUES ('/admin/assignment/*', '2', null, null, null, '1443338691', '1443338691');
INSERT INTO `pop_auth_item` VALUES ('/admin/assignment/assign', '2', null, null, null, '1443338691', '1443338691');
INSERT INTO `pop_auth_item` VALUES ('/admin/assignment/index', '2', null, null, null, '1443338691', '1443338691');
INSERT INTO `pop_auth_item` VALUES ('/admin/assignment/search', '2', null, null, null, '1443338691', '1443338691');
INSERT INTO `pop_auth_item` VALUES ('/admin/assignment/view', '2', null, null, null, '1443338691', '1443338691');
INSERT INTO `pop_auth_item` VALUES ('/admin/default/*', '2', null, null, null, '1443338691', '1443338691');
INSERT INTO `pop_auth_item` VALUES ('/admin/default/index', '2', null, null, null, '1443338691', '1443338691');
INSERT INTO `pop_auth_item` VALUES ('/admin/menu/*', '2', null, null, null, '1443338691', '1443338691');
INSERT INTO `pop_auth_item` VALUES ('/admin/menu/create', '2', null, null, null, '1443338691', '1443338691');
INSERT INTO `pop_auth_item` VALUES ('/admin/menu/delete', '2', null, null, null, '1443338691', '1443338691');
INSERT INTO `pop_auth_item` VALUES ('/admin/menu/index', '2', null, null, null, '1443338691', '1443338691');
INSERT INTO `pop_auth_item` VALUES ('/admin/menu/update', '2', null, null, null, '1443338691', '1443338691');
INSERT INTO `pop_auth_item` VALUES ('/admin/menu/view', '2', null, null, null, '1443338691', '1443338691');
INSERT INTO `pop_auth_item` VALUES ('/admin/permission/*', '2', null, null, null, '1443338691', '1443338691');
INSERT INTO `pop_auth_item` VALUES ('/admin/permission/assign', '2', null, null, null, '1443338691', '1443338691');
INSERT INTO `pop_auth_item` VALUES ('/admin/permission/create', '2', null, null, null, '1443338691', '1443338691');
INSERT INTO `pop_auth_item` VALUES ('/admin/permission/delete', '2', null, null, null, '1443338691', '1443338691');
INSERT INTO `pop_auth_item` VALUES ('/admin/permission/index', '2', null, null, null, '1443338691', '1443338691');
INSERT INTO `pop_auth_item` VALUES ('/admin/permission/search', '2', null, null, null, '1443338691', '1443338691');
INSERT INTO `pop_auth_item` VALUES ('/admin/permission/update', '2', null, null, null, '1443338691', '1443338691');
INSERT INTO `pop_auth_item` VALUES ('/admin/permission/view', '2', null, null, null, '1443338691', '1443338691');
INSERT INTO `pop_auth_item` VALUES ('/admin/role/*', '2', null, null, null, '1443338691', '1443338691');
INSERT INTO `pop_auth_item` VALUES ('/admin/role/assign', '2', null, null, null, '1443338691', '1443338691');
INSERT INTO `pop_auth_item` VALUES ('/admin/role/create', '2', null, null, null, '1443338691', '1443338691');
INSERT INTO `pop_auth_item` VALUES ('/admin/role/delete', '2', null, null, null, '1443338691', '1443338691');
INSERT INTO `pop_auth_item` VALUES ('/admin/role/index', '2', null, null, null, '1443338691', '1443338691');
INSERT INTO `pop_auth_item` VALUES ('/admin/role/search', '2', null, null, null, '1443338691', '1443338691');
INSERT INTO `pop_auth_item` VALUES ('/admin/role/update', '2', null, null, null, '1443338691', '1443338691');
INSERT INTO `pop_auth_item` VALUES ('/admin/role/view', '2', null, null, null, '1443338691', '1443338691');
INSERT INTO `pop_auth_item` VALUES ('/admin/route/*', '2', null, null, null, '1443338691', '1443338691');
INSERT INTO `pop_auth_item` VALUES ('/admin/route/assign', '2', null, null, null, '1443338691', '1443338691');
INSERT INTO `pop_auth_item` VALUES ('/admin/route/create', '2', null, null, null, '1443338691', '1443338691');
INSERT INTO `pop_auth_item` VALUES ('/admin/route/index', '2', null, null, null, '1443331254', '1443331254');
INSERT INTO `pop_auth_item` VALUES ('/admin/route/search', '2', null, null, null, '1443331233', '1443331233');
INSERT INTO `pop_auth_item` VALUES ('/admin/rule/*', '2', null, null, null, '1443338692', '1443338692');
INSERT INTO `pop_auth_item` VALUES ('/admin/rule/create', '2', null, null, null, '1443338692', '1443338692');
INSERT INTO `pop_auth_item` VALUES ('/admin/rule/delete', '2', null, null, null, '1443338692', '1443338692');
INSERT INTO `pop_auth_item` VALUES ('/admin/rule/index', '2', null, null, null, '1443338692', '1443338692');
INSERT INTO `pop_auth_item` VALUES ('/admin/rule/update', '2', null, null, null, '1443338692', '1443338692');
INSERT INTO `pop_auth_item` VALUES ('/admin/rule/view', '2', null, null, null, '1443338692', '1443338692');
INSERT INTO `pop_auth_item` VALUES ('/api/*', '2', null, null, null, '1443338692', '1443338692');
INSERT INTO `pop_auth_item` VALUES ('/api/create', '2', null, null, null, '1443338692', '1443338692');
INSERT INTO `pop_auth_item` VALUES ('/api/delete', '2', null, null, null, '1443338692', '1443338692');
INSERT INTO `pop_auth_item` VALUES ('/api/error', '2', null, null, null, '1443338692', '1443338692');
INSERT INTO `pop_auth_item` VALUES ('/api/index', '2', null, null, null, '1443338692', '1443338692');
INSERT INTO `pop_auth_item` VALUES ('/api/update', '2', null, null, null, '1443338692', '1443338692');
INSERT INTO `pop_auth_item` VALUES ('/api/view', '2', null, null, null, '1443338692', '1443338692');
INSERT INTO `pop_auth_item` VALUES ('/base/*', '2', null, null, null, '1443338692', '1443338692');
INSERT INTO `pop_auth_item` VALUES ('/base/error', '2', null, null, null, '1443338692', '1443338692');
INSERT INTO `pop_auth_item` VALUES ('/config/*', '2', null, null, null, '1443338692', '1443338692');
INSERT INTO `pop_auth_item` VALUES ('/config/create', '2', null, null, null, '1443338692', '1443338692');
INSERT INTO `pop_auth_item` VALUES ('/config/delete', '2', null, null, null, '1443338692', '1443338692');
INSERT INTO `pop_auth_item` VALUES ('/config/error', '2', null, null, null, '1443338692', '1443338692');
INSERT INTO `pop_auth_item` VALUES ('/config/index', '2', null, null, null, '1443338692', '1443338692');
INSERT INTO `pop_auth_item` VALUES ('/config/update', '2', null, null, null, '1443338692', '1443338692');
INSERT INTO `pop_auth_item` VALUES ('/config/view', '2', null, null, null, '1443338692', '1443338692');
INSERT INTO `pop_auth_item` VALUES ('/coupon/*', '2', null, null, null, '1443338692', '1443338692');
INSERT INTO `pop_auth_item` VALUES ('/coupon/create', '2', null, null, null, '1443338692', '1443338692');
INSERT INTO `pop_auth_item` VALUES ('/coupon/delete', '2', null, null, null, '1443338692', '1443338692');
INSERT INTO `pop_auth_item` VALUES ('/coupon/error', '2', null, null, null, '1443338692', '1443338692');
INSERT INTO `pop_auth_item` VALUES ('/coupon/index', '2', null, null, null, '1443338692', '1443338692');
INSERT INTO `pop_auth_item` VALUES ('/coupon/update', '2', null, null, null, '1443338692', '1443338692');
INSERT INTO `pop_auth_item` VALUES ('/coupon/view', '2', null, null, null, '1443338692', '1443338692');
INSERT INTO `pop_auth_item` VALUES ('/debug/*', '2', null, null, null, '1443408210', '1443408210');
INSERT INTO `pop_auth_item` VALUES ('/debug/default/*', '2', null, null, null, '1443408210', '1443408210');
INSERT INTO `pop_auth_item` VALUES ('/debug/default/db-explain', '2', null, null, null, '1443408210', '1443408210');
INSERT INTO `pop_auth_item` VALUES ('/debug/default/download-mail', '2', null, null, null, '1443408210', '1443408210');
INSERT INTO `pop_auth_item` VALUES ('/debug/default/index', '2', null, null, null, '1443408210', '1443408210');
INSERT INTO `pop_auth_item` VALUES ('/debug/default/toolbar', '2', null, null, null, '1443408210', '1443408210');
INSERT INTO `pop_auth_item` VALUES ('/debug/default/view', '2', null, null, null, '1443408210', '1443408210');
INSERT INTO `pop_auth_item` VALUES ('/gii/*', '2', null, null, null, '1443338692', '1443338692');
INSERT INTO `pop_auth_item` VALUES ('/gii/default/*', '2', null, null, null, '1443338692', '1443338692');
INSERT INTO `pop_auth_item` VALUES ('/gii/default/action', '2', null, null, null, '1443338692', '1443338692');
INSERT INTO `pop_auth_item` VALUES ('/gii/default/diff', '2', null, null, null, '1443338692', '1443338692');
INSERT INTO `pop_auth_item` VALUES ('/gii/default/index', '2', null, null, null, '1443338692', '1443338692');
INSERT INTO `pop_auth_item` VALUES ('/gii/default/preview', '2', null, null, null, '1443338692', '1443338692');
INSERT INTO `pop_auth_item` VALUES ('/gii/default/view', '2', null, null, null, '1443338692', '1443338692');
INSERT INTO `pop_auth_item` VALUES ('/old-dazhong-order/*', '2', null, null, null, '1443338692', '1443338692');
INSERT INTO `pop_auth_item` VALUES ('/old-dazhong-order/create', '2', null, null, null, '1443338692', '1443338692');
INSERT INTO `pop_auth_item` VALUES ('/old-dazhong-order/delete', '2', null, null, null, '1443338692', '1443338692');
INSERT INTO `pop_auth_item` VALUES ('/old-dazhong-order/index', '2', null, null, null, '1443338692', '1443338692');
INSERT INTO `pop_auth_item` VALUES ('/old-dazhong-order/update', '2', null, null, null, '1443338692', '1443338692');
INSERT INTO `pop_auth_item` VALUES ('/old-dazhong-order/view', '2', null, null, null, '1443338692', '1443338692');
INSERT INTO `pop_auth_item` VALUES ('/old-meituan-order/*', '2', null, null, null, '1443338692', '1443338692');
INSERT INTO `pop_auth_item` VALUES ('/old-meituan-order/index', '2', null, null, null, '1443338692', '1443338692');
INSERT INTO `pop_auth_item` VALUES ('/order-log/*', '2', null, null, null, '1446267968', '1446267968');
INSERT INTO `pop_auth_item` VALUES ('/order-log/create', '2', null, null, null, '1446267968', '1446267968');
INSERT INTO `pop_auth_item` VALUES ('/order-log/delete', '2', null, null, null, '1446267968', '1446267968');
INSERT INTO `pop_auth_item` VALUES ('/order-log/index', '2', null, null, null, '1446267968', '1446267968');
INSERT INTO `pop_auth_item` VALUES ('/order-log/update', '2', null, null, null, '1446267968', '1446267968');
INSERT INTO `pop_auth_item` VALUES ('/order-log/view', '2', null, null, null, '1446267968', '1446267968');
INSERT INTO `pop_auth_item` VALUES ('/order/*', '2', null, null, null, '1443338692', '1443338692');
INSERT INTO `pop_auth_item` VALUES ('/order/create', '2', null, null, null, '1443338692', '1443338692');
INSERT INTO `pop_auth_item` VALUES ('/order/delete', '2', null, null, null, '1443338692', '1443338692');
INSERT INTO `pop_auth_item` VALUES ('/order/error', '2', null, null, null, '1443338692', '1443338692');
INSERT INTO `pop_auth_item` VALUES ('/order/index', '2', null, null, null, '1443338692', '1443338692');
INSERT INTO `pop_auth_item` VALUES ('/order/push-status-done', '2', null, null, null, '1446267968', '1446267968');
INSERT INTO `pop_auth_item` VALUES ('/order/update', '2', null, null, null, '1443338692', '1443338692');
INSERT INTO `pop_auth_item` VALUES ('/order/view', '2', null, null, null, '1443338692', '1443338692');
INSERT INTO `pop_auth_item` VALUES ('/params/*', '2', null, null, null, '1443338692', '1443338692');
INSERT INTO `pop_auth_item` VALUES ('/params/create', '2', null, null, null, '1443338692', '1443338692');
INSERT INTO `pop_auth_item` VALUES ('/params/delete', '2', null, null, null, '1443338692', '1443338692');
INSERT INTO `pop_auth_item` VALUES ('/params/error', '2', null, null, null, '1443338692', '1443338692');
INSERT INTO `pop_auth_item` VALUES ('/params/index', '2', null, null, null, '1443338692', '1443338692');
INSERT INTO `pop_auth_item` VALUES ('/params/update', '2', null, null, null, '1443338692', '1443338692');
INSERT INTO `pop_auth_item` VALUES ('/params/view', '2', null, null, null, '1443338692', '1443338692');
INSERT INTO `pop_auth_item` VALUES ('/partner/*', '2', null, null, null, '1443338692', '1443338692');
INSERT INTO `pop_auth_item` VALUES ('/partner/create', '2', null, null, null, '1443338692', '1443338692');
INSERT INTO `pop_auth_item` VALUES ('/partner/delete', '2', null, null, null, '1443338692', '1443338692');
INSERT INTO `pop_auth_item` VALUES ('/partner/error', '2', null, null, null, '1443338692', '1443338692');
INSERT INTO `pop_auth_item` VALUES ('/partner/index', '2', null, null, null, '1443338692', '1443338692');
INSERT INTO `pop_auth_item` VALUES ('/partner/update', '2', null, null, null, '1443338692', '1443338692');
INSERT INTO `pop_auth_item` VALUES ('/partner/view', '2', null, null, null, '1443338692', '1443338692');
INSERT INTO `pop_auth_item` VALUES ('/range/*', '2', null, null, null, '1443338692', '1443338692');
INSERT INTO `pop_auth_item` VALUES ('/range/create', '2', null, null, null, '1443338692', '1443338692');
INSERT INTO `pop_auth_item` VALUES ('/range/delete', '2', null, null, null, '1443338692', '1443338692');
INSERT INTO `pop_auth_item` VALUES ('/range/error', '2', null, null, null, '1443338692', '1443338692');
INSERT INTO `pop_auth_item` VALUES ('/range/index', '2', null, null, null, '1443338692', '1443338692');
INSERT INTO `pop_auth_item` VALUES ('/range/update', '2', null, null, null, '1443338692', '1443338692');
INSERT INTO `pop_auth_item` VALUES ('/service/*', '2', null, null, null, '1446267959', '1446267959');
INSERT INTO `pop_auth_item` VALUES ('/service/create', '2', null, null, null, '1446267959', '1446267959');
INSERT INTO `pop_auth_item` VALUES ('/service/delete', '2', null, null, null, '1446267959', '1446267959');
INSERT INTO `pop_auth_item` VALUES ('/service/index', '2', null, null, null, '1446267959', '1446267959');
INSERT INTO `pop_auth_item` VALUES ('/service/update', '2', null, null, null, '1446267959', '1446267959');
INSERT INTO `pop_auth_item` VALUES ('/service/view', '2', null, null, null, '1446267959', '1446267959');
INSERT INTO `pop_auth_item` VALUES ('/site/*', '2', null, null, null, '1443338692', '1443338692');
INSERT INTO `pop_auth_item` VALUES ('/site/error', '2', null, null, null, '1443338692', '1443338692');
INSERT INTO `pop_auth_item` VALUES ('/site/flush', '2', null, null, null, '1446267959', '1446267959');
INSERT INTO `pop_auth_item` VALUES ('/site/index', '2', null, null, null, '1443338692', '1443338692');
INSERT INTO `pop_auth_item` VALUES ('/site/login', '2', null, null, null, '1443338692', '1443338692');
INSERT INTO `pop_auth_item` VALUES ('/site/logout', '2', null, null, null, '1443338692', '1443338692');
INSERT INTO `pop_auth_item` VALUES ('/user/*', '2', null, null, null, '1443338692', '1443338692');
INSERT INTO `pop_auth_item` VALUES ('/user/create', '2', null, null, null, '1443338692', '1443338692');
INSERT INTO `pop_auth_item` VALUES ('/user/delete', '2', null, null, null, '1443338692', '1443338692');
INSERT INTO `pop_auth_item` VALUES ('/user/error', '2', null, null, null, '1443338692', '1443338692');
INSERT INTO `pop_auth_item` VALUES ('/user/index', '2', null, null, null, '1443338692', '1443338692');
INSERT INTO `pop_auth_item` VALUES ('/user/reset-password', '2', null, null, null, '1446536063', '1446536063');
INSERT INTO `pop_auth_item` VALUES ('/user/update', '2', null, null, null, '1443338692', '1443338692');
INSERT INTO `pop_auth_item` VALUES ('/user/view', '2', null, null, null, '1443338692', '1443338692');
INSERT INTO `pop_auth_item` VALUES ('author', '1', null, null, null, '1443080982', '1443080982');
INSERT INTO `pop_auth_item` VALUES ('superAdmin', '1', '超级管理员', null, null, '1443080982', '1443408507');

-- ----------------------------
-- Table structure for pop_auth_item_child
-- ----------------------------
DROP TABLE IF EXISTS `pop_auth_item_child`;
CREATE TABLE `pop_auth_item_child` (
  `parent` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `child` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`parent`,`child`),
  KEY `child` (`child`),
  CONSTRAINT `pop_auth_item_child_ibfk_1` FOREIGN KEY (`parent`) REFERENCES `pop_auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `pop_auth_item_child_ibfk_2` FOREIGN KEY (`child`) REFERENCES `pop_auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of pop_auth_item_child
-- ----------------------------
INSERT INTO `pop_auth_item_child` VALUES ('superAdmin', '/*');

-- ----------------------------
-- Table structure for pop_auth_rule
-- ----------------------------
DROP TABLE IF EXISTS `pop_auth_rule`;
CREATE TABLE `pop_auth_rule` (
  `name` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `data` text COLLATE utf8_unicode_ci,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of pop_auth_rule
-- ----------------------------

-- ----------------------------
-- Table structure for pop_category
-- ----------------------------
DROP TABLE IF EXISTS `pop_category`;
CREATE TABLE `pop_category` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(50) NOT NULL COMMENT '名字',
  `pid` int(11) NOT NULL DEFAULT '0' COMMENT '父id',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of pop_category
-- ----------------------------

-- ----------------------------
-- Table structure for pop_gather
-- ----------------------------
DROP TABLE IF EXISTS `pop_gather`;
CREATE TABLE `pop_gather` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `category` varchar(255) NOT NULL,
  `url` varchar(255) NOT NULL,
  `url_org` varchar(255) NOT NULL,
  `res` tinyint(1) NOT NULL DEFAULT '1',
  `result` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=52 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of pop_gather
-- ----------------------------
INSERT INTO `pop_gather` VALUES ('1', 'neihan', '段子', 'ed23bf953a6294fdb530d74f09f56859', 'http://neihanshequ.com/p5771428377/', '1', '兔宝宝提莫6');
INSERT INTO `pop_gather` VALUES ('2', 'neihan', '段子', '1265ad17002f24d11f25e1b179ee4ec0', 'http://neihanshequ.com/p5769538493/', '1', '一马-赛-克');
INSERT INTO `pop_gather` VALUES ('3', 'neihan', '段子', 'bbade86978a1b6fd8e93009797cb75d8', 'http://neihanshequ.com/p5774689217/', '1', '伊梦华胥_消沉');
INSERT INTO `pop_gather` VALUES ('4', 'neihan', '段子', 'a1203b95c3b9434f69f137eb67ecd019', 'http://neihanshequ.com/p5757162558/', '1', 'Mustang77');
INSERT INTO `pop_gather` VALUES ('5', 'neihan', '段子', 'ce8cb94ce829d449f7c51ca385bab011', 'http://neihanshequ.com/p5734685906/', '1', '匿名用户');
INSERT INTO `pop_gather` VALUES ('6', 'neihan', '段子', 'ef1b2886353d2e0a9eefc62ad9ebe8fa', 'http://neihanshequ.com/p5773619462/', '1', '最红不过大姨妈-');
INSERT INTO `pop_gather` VALUES ('7', 'neihan', '段子', 'a6233992f02d2c9d1b50f89c917a4043', 'http://neihanshequ.com/p5769443291/', '1', '风与酒伴我走');
INSERT INTO `pop_gather` VALUES ('8', 'neihan', '段子', '52f259edbd33cc3ef38e4da2dc7f44cb', 'http://neihanshequ.com/p5759678309/', '1', '愿望18991784');
INSERT INTO `pop_gather` VALUES ('9', 'neihan', '段子', '219db7a51aa28be61848b07940690b2c', 'http://neihanshequ.com/p5776938788/', '1', 'Mustang77');
INSERT INTO `pop_gather` VALUES ('10', 'neihan', '段子', 'df29b3c47fb478d3ad301c85d84bb436', 'http://neihanshequ.com/p5752748176/', '1', '一个人一座城59217399');
INSERT INTO `pop_gather` VALUES ('11', 'neihan', '段子', 'a46b78e4c2218ef6d5c977af0b758255', 'http://neihanshequ.com/p5745544142/', '1', '三胖大爷');
INSERT INTO `pop_gather` VALUES ('12', 'neihan', '段子', 'd0fb56203e29a99c472f06d79dda9277', 'http://neihanshequ.com/p5719958098/', '1', '独忍那滴泪');
INSERT INTO `pop_gather` VALUES ('13', 'neihan', '段子', '505281cc6ae98a5d78e94ebe88af18c1', 'http://neihanshequ.com/p5776854467/', '1', '亲亲尓微笑');
INSERT INTO `pop_gather` VALUES ('14', 'neihan', '段子', '1ed119d1f9c5bf968f9b961ee94eba9c', 'http://neihanshequ.com/p5748726967/', '1', '我是你的小依赖9622716');
INSERT INTO `pop_gather` VALUES ('15', 'neihan', '段子', 'bf8b63ff37d2819545f5f0c7193e283e', 'http://neihanshequ.com/p5745967276/', '1', '半脸妆_晴儿');
INSERT INTO `pop_gather` VALUES ('16', 'neihan', '段子', 'c725c37056414b2983e4047824652d35', 'http://neihanshequ.com/p5742182612/', '1', '鹰的高度豹的速度');
INSERT INTO `pop_gather` VALUES ('17', 'neihan', '段子', 'ce15aad33aefd8c649b5ee755c6ffc5e', 'http://neihanshequ.com/p5776946918/', '1', '不结果地花依然灿烂');
INSERT INTO `pop_gather` VALUES ('18', 'neihan', '段子', '8e1ef1eb0d79a583c1fbe278755952dd', 'http://neihanshequ.com/p5752381255/', '1', '无证斋');
INSERT INTO `pop_gather` VALUES ('19', 'neihan', '段子', 'aa1eed9a56247908be8df392bbbb4b91', 'http://neihanshequ.com/p5745869602/', '1', '__阿徽');
INSERT INTO `pop_gather` VALUES ('20', 'neihan', '段子', '32bfe077fd512fcb1ea3324c50ebd52b', 'http://neihanshequ.com/p5557108766/', '1', '开拓19190480');
INSERT INTO `pop_gather` VALUES ('21', 'neihan', '段子', 'cc281195d2eeb3cb33b2279b34c9116c', 'http://neihanshequ.com/p5756867231/', '1', '匿名用户');
INSERT INTO `pop_gather` VALUES ('22', 'neihan', '段子', 'c8f734dbc280ffdcc6db71fdf2a81869', 'http://neihanshequ.com/p5756478354/', '1', '飞翔的糖豆');
INSERT INTO `pop_gather` VALUES ('23', 'neihan', '段子', 'aac06c2c4081ca0ebaa5834f6d167a3d', 'http://neihanshequ.com/p5776939976/', '1', 'Mustang77');
INSERT INTO `pop_gather` VALUES ('24', 'neihan', '段子', 'f50f9b101b04741f032a933f4060277f', 'http://neihanshequ.com/p5772564882/', '1', '梦中捞月');
INSERT INTO `pop_gather` VALUES ('25', 'neihan', '段子', 'bf4305c0f15287509bf82cad69db6302', 'http://neihanshequ.com/p5639543311/', '1', '情迷LasVegass');
INSERT INTO `pop_gather` VALUES ('26', 'neihan', '段子', '50b9981df1d1622dd3a5309c20e412c5', 'http://neihanshequ.com/p5772222096/', '1', 'Mustang77');
INSERT INTO `pop_gather` VALUES ('27', 'neihan', '段子', 'e3f2bed214ac383f2a14e3bee6b4ef4e', 'http://neihanshequ.com/p5746847401/', '1', 'Mustang77');
INSERT INTO `pop_gather` VALUES ('28', 'neihan', '段子', '863a30203e45a9821904a2e8ff10d7d7', 'http://neihanshequ.com/p5763501158/', '1', '床上一抹红');
INSERT INTO `pop_gather` VALUES ('29', 'neihan', '段子', '363027278d56456b77044b63c001928b', 'http://neihanshequ.com/p5638774932/', '1', '姑娘别装哥看不见');
INSERT INTO `pop_gather` VALUES ('30', 'neihan', '段子', '2a30741ec924baceefce70d64b826e9b', 'http://neihanshequ.com/p5728544867/', '1', '伊梦华胥_消沉');
INSERT INTO `pop_gather` VALUES ('31', 'neihan', '段子', '999f0cb42c7ca3a312cd95d75c20de96', 'http://neihanshequ.com/p5756234222/', '1', '伊梦华胥_消沉');
INSERT INTO `pop_gather` VALUES ('32', 'neihan', '段子', '4b794740b86fc95eee43e319c1aba3ef', 'http://neihanshequ.com/p5743516796/', '1', '人潮24334842');
INSERT INTO `pop_gather` VALUES ('33', 'neihan', '段子', '6a22ae010a4863030eea45691f3256ba', 'http://neihanshequ.com/p5725856947/', '1', '我就是隔壁还没成老王的小王');
INSERT INTO `pop_gather` VALUES ('34', 'neihan', '段子', '2c250f6505316876210dc78c2dea1b2a', 'http://neihanshequ.com/p5776953258/', '1', '隔壁老痒');
INSERT INTO `pop_gather` VALUES ('35', 'neihan', '段子', '7d9d9e1cca9450c82f4346b80ecf6c4b', 'http://neihanshequ.com/p5772761386/', '1', '半脸妆_晴儿');
INSERT INTO `pop_gather` VALUES ('36', 'neihan', '段子', '212a3db3ecd3dc40cf9b736704512adf', 'http://neihanshequ.com/p5726685568/', '1', 'Mustang77');
INSERT INTO `pop_gather` VALUES ('37', 'neihan', '段子', '66a70966f467add72f7f81f0b274e6a1', 'http://neihanshequ.com/p5772229201/', '1', 'Mustang77');
INSERT INTO `pop_gather` VALUES ('38', 'neihan', '段子', '43cab64bcc43c0a5091fef4e4b58c0ec', 'http://neihanshequ.com/p5756852873/', '1', '用户62542862');
INSERT INTO `pop_gather` VALUES ('39', 'neihan', '段子', '285fc6127ed089c4bc1dfa66d6891799', 'http://neihanshequ.com/p5772641965/', '1', '黄埔云儿');
INSERT INTO `pop_gather` VALUES ('40', 'neihan', '段子', 'a943f1af3a503b0006390c934a91d5c0', 'http://neihanshequ.com/p5772012477/', '1', '蹦傻噶啦哈');
INSERT INTO `pop_gather` VALUES ('41', 'neihan', '段子', '219db7a51aa28be61848b07940690b2c', 'http://neihanshequ.com/p5776938788/', '1', 'Mustang77');
INSERT INTO `pop_gather` VALUES ('42', 'neihan', '段子', 'e3418d3e6001aabd4344b884bd866c2e', 'http://neihanshequ.com/p5736779722/', '1', '魄56079591');
INSERT INTO `pop_gather` VALUES ('43', 'neihan', '段子', '52f259edbd33cc3ef38e4da2dc7f44cb', 'http://neihanshequ.com/p5759678309/', '1', '愿望18991784');
INSERT INTO `pop_gather` VALUES ('44', 'neihan', '段子', 'a56a40e168da4cbd73311ca764afcc02', 'http://neihanshequ.com/p5771682388/', '1', '李军64088128');
INSERT INTO `pop_gather` VALUES ('45', 'neihan', '段子', '67243064095a7c3210c5cec818c0df4f', 'http://neihanshequ.com/p5726363731/', '1', '慢热房客');
INSERT INTO `pop_gather` VALUES ('46', 'neihan', '段子', '505281cc6ae98a5d78e94ebe88af18c1', 'http://neihanshequ.com/p5776854467/', '1', '亲亲尓微笑');
INSERT INTO `pop_gather` VALUES ('47', 'neihan', '段子', '1ed119d1f9c5bf968f9b961ee94eba9c', 'http://neihanshequ.com/p5748726967/', '1', '我是你的小依赖9622716');
INSERT INTO `pop_gather` VALUES ('48', 'neihan', '段子', '06f70d6641401aa70948dea5112ca44a', 'http://neihanshequ.com/p5736920672/', '1', '七秒锺记忆');
INSERT INTO `pop_gather` VALUES ('49', 'neihan', '段子', '28c554fc7047a2f3f3378a9c7d70dfae', 'http://neihanshequ.com/p5776906718/', '1', 'Mustang77');
INSERT INTO `pop_gather` VALUES ('50', 'neihan', '段子', 'f0c70df97d48437c4adddbdd5fe6e51e', 'http://neihanshequ.com/p5771639837/', '1', '最好的满足是你给的在乎10797253');
INSERT INTO `pop_gather` VALUES ('51', 'neihan', '段子', 'c725c37056414b2983e4047824652d35', 'http://neihanshequ.com/p5742182612/', '1', '鹰的高度豹的速度');

-- ----------------------------
-- Table structure for pop_menu
-- ----------------------------
DROP TABLE IF EXISTS `pop_menu`;
CREATE TABLE `pop_menu` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(128) NOT NULL,
  `parent` int(11) DEFAULT NULL,
  `route` varchar(256) DEFAULT NULL,
  `order` int(11) DEFAULT NULL,
  `data` text,
  PRIMARY KEY (`id`),
  KEY `parent` (`parent`),
  CONSTRAINT `pop_menu_ibfk_1` FOREIGN KEY (`parent`) REFERENCES `pop_menu` (`id`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of pop_menu
-- ----------------------------
INSERT INTO `pop_menu` VALUES ('1', '系统管理', null, null, '1', null);
INSERT INTO `pop_menu` VALUES ('2', '菜单管理', '1', '/admin/menu/index', null, null);
INSERT INTO `pop_menu` VALUES ('15', '用户管理', '1', '/admin/assignment/index', null, null);
INSERT INTO `pop_menu` VALUES ('16', '路由管理', '1', '/admin/route/index', null, null);
INSERT INTO `pop_menu` VALUES ('17', '角色管理', '1', '/admin/role/index', null, null);
INSERT INTO `pop_menu` VALUES ('20', '控制面板', null, '/site/index', '1', null);

-- ----------------------------
-- Table structure for pop_nav
-- ----------------------------
DROP TABLE IF EXISTS `pop_nav`;
CREATE TABLE `pop_nav` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL COMMENT '名称',
  `route` varchar(255) NOT NULL COMMENT '路由',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of pop_nav
-- ----------------------------
INSERT INTO `pop_nav` VALUES ('1', '列表', 'article/list');

-- ----------------------------
-- Table structure for pop_spider
-- ----------------------------
DROP TABLE IF EXISTS `pop_spider`;
CREATE TABLE `pop_spider` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(20) NOT NULL COMMENT '标识',
  `title` varchar(100) NOT NULL COMMENT '名称',
  `domain` varchar(255) NOT NULL COMMENT '域名',
  `page_dom` varchar(255) NOT NULL COMMENT '分页链接元素',
  `list_dom` varchar(255) NOT NULL COMMENT '列表链接元素',
  `time_dom` varchar(255) DEFAULT NULL COMMENT '内容页时间元素',
  `content_dom` varchar(255) NOT NULL COMMENT '内容页内容元素',
  `title_dom` varchar(255) NOT NULL COMMENT '内容页标题元素',
  `target_category` varchar(255) NOT NULL COMMENT '目标分类',
  `target_category_url` varchar(255) NOT NULL COMMENT '目标分类地址',
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of pop_spider
-- ----------------------------
INSERT INTO `pop_spider` VALUES ('1', 'chncomic', '中国国际动漫网', 'http://www.chncomic.com', '.page_div ul li a', '.info_list h1 a', '.time span', '.article_con', '.w_640 h1.article_title', '影视', 'http://www.chncomic.com/info/yingshi');
INSERT INTO `pop_spider` VALUES ('2', 'neihan', '内涵段子', 'http://neihanshequ.com', '', '.share_url', null, '.content-wrapper .upload-txt', '.name-time-wrapper .name', '段子', 'http://neihanshequ.com');

-- ----------------------------
-- Table structure for pop_user
-- ----------------------------
DROP TABLE IF EXISTS `pop_user`;
CREATE TABLE `pop_user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `auth_key` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `password_hash` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password_reset_token` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `status` smallint(6) NOT NULL DEFAULT '10',
  `created_at` int(11) NOT NULL,
  `updated_at` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of pop_user
-- ----------------------------
INSERT INTO `pop_user` VALUES ('1', 'hehe', '1lQl4TG6sYlyWRqXZEWL0ZhQkPATVnMs', '$2y$13$8n0PJFk7ZDea4YdMYho2XeFHbrBWADKM9NYdmnm8R0qBov969sTY.', null, 'liujuntaor@qq.com', '10', '1441766741', '1446535118');
