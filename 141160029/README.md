# 程序编码课程作业
141160029 李向阳

## Python分析

### Python简介

Python是一种广泛使用的高级编程语言，属于通用型编程语言，由吉多·范罗苏姆创造，第一版发布于 1991 年。
可以視之為一種改良（加入一些其他程式語言的優點，如物件導向）的 LISP。
作为一种解释型语言，Python 的设计哲学强调代码的可读性和简洁的语法（尤其是使用空格缩进划分代码块，而非使用大括号或者关键词）。
相比於 C++ 或 Java，Python 让开发者能够用更少的代码表达想法。不管是小型还是大型程序，该语言都试图让程序的结构清晰明了。

### Python语言特点

#### 优点

- 语法简洁，写法偏向与自然语言，学习成本低，可读性高，语义表现型强，程序员友好；
- 动态类型，使用极其便利；
- 支持面向过程、面向对象、命令式和函数式编程等多种编程范式；
- 动态内存管理，垃圾回收极机制；
- 方便的语法糖，可以以很短的代码实现功能多且强大的功能。

### 缺点

- 解释型语言，运行较慢（现在已有编译器将Python编译到C）；
- 动态类型，导致项目过大时，可读性不高且维护不易；
- Python2到Python3转变时，为了刨除语言设计的一些缺陷和提高性能，导致了大量的兼容性问题；
- 面向对象的不完全（相对于JAVA）。

### Python的主要使用范围

Python的优点以及其缺点，决定了它很适合做一些对效率要求不那么苛刻且需要较高的开发效率的程序
，所以Python在命令行程序、中小型的Web程序、GUI界面等方面有大量应用。在这其中代表程序有Request
网络库、Flask Web框架、Dropbox的GUI客户端等。

### Python为什么流行

Python上手的易用性导致了很多非编程专业人士入门编程，积累了大量的使用者；同时这些使用者又反过来，
编写了大量方便开源的第三方库包文件，形成了Python良好的生态与社区氛围。同时一些大公司（Twitter，Google，Youtube等）使用Python编写他们的应用程序并获得了成功，表明Python在按照合理的规范进行开发时，是可以胜任大型项目的。

针对Python运行效率慢的问题，开发人员开发了Pypy等高校的Python实现，同时也能把Python编译到C语言，
提高Python的效率。
同时，针对大型项目的一些高性能要求部分（高并发），采用C/C++等高效的语言进行开发，Python为与这些
语言交互提供了较好支持。

## wxpy微信机器人代码分析

### 项目简介

此处分析主要程序[bot.py](https://github.com/youfou/wxpy/blob/master/wxpy/api/bot.py)中的Bot类，此类为此微信机器人的核心实现。

此项目在类的命名上采用大驼峰命名法，在变量与方法上则采用下划线的方法。同时此项目中还是用了Python的
函数式编程（高阶的Warper函数）。

### 序言性注释

由于此项目规模较小，针对核心内容并没有序言性注释，而是在项目主页给出了项目的主要介绍文件([README.md](https://github.com/youfou/wxpy/blob/master/README.rst)，其中包括作者信息，支持的Python版本以及简单的使用说明，更新日志连接，并在其中附上了详细使用手册的连接)、项目的[LICENSE](https://github.com/youfou/wxpy/blob/master/LICENSE)以及项目的依赖([Reqirement](https://github.com/youfou/wxpy/blob/master/requirements.txt))。在一般的序言性注释中，通常也是包括上述各个部分。

### 源代码分析

*  

  ```
  class Bot(object):
  ```

  此处定义并实现了Bot这个核心类。

  功能性注释：机器人对象，用于登陆和操作微信账号，涵盖大部分 Web 微信的功能。

*  

  ```Python
  def __init__(
          self, cache_path=None, console_qr=False, qr_path=None,
          qr_callback=None, login_callback=None, logout_callback=None
  ):
  ```

  Bot类的构造函数，创建Bot类时传入参数构造Bot类。

  功能性注释：
  ```
  :param cache_path:
    * 设置当前会话的缓存路径，并开启缓存功能；为 `None` (默认) 则不开启缓存功能。
    * 开启缓存后可在短时间内避免重复扫码，缓存失效时会重新要求登陆。
    * 设为 `True` 时，使用默认的缓存路径 'wxpy.pkl'。
  :param console_qr:
    * 在终端中显示登陆二维码，需要安装 pillow 模块 (`pip3 install pillow`)。
    * 可为整数(int)，表示二维码单元格的宽度，通常为 2 (当被设为 `True` 时，也将在内部当作 2)。
    * 也可为负数，表示以反色显示二维码，适用于浅底深字的命令行界面。
    * 例如: 在大部分 Linux 系统中可设为 `True` 或 2，而在 macOS Terminal 的默认白底配色中，应设为 -2。
  :param qr_path: 保存二维码的路径
  :param qr_callback: 获得二维码后的回调，可以用来定义二维码的处理方式，接收参数: uuid, status, qrcode
  :param login_callback: 登陆成功后的回调，若不指定，将进行清屏操作，并删除二维码文件
  :param logout_callback: 登出时的回调
  ```

*  
  ```Python
  @force_encoded_string_output
  def __repr__(self):
  ```
  函数的表示，@force_encoded_string_output对强制进行string转换，美化类调用的输出。

  功能性注释:
  ```
  无
  ```
*  

  ```Python
  def __unicode__(self):
  ```
  同上。

  功能性注释：
  ```
  无
  ```

*  

  ```Python
  @handle_response()
  def logout(self):
  ```
  登出帐号。

  功能性注释：
  ```
  登出当前账号
  ```

*  

  ```Python
  @property
  def alive(self):
  ```
  判断用户的登录状态。

  功能性注释：
  ```
  若为登陆状态，则为 True，否则为 False
  ```

*  

  ```Python
  @alive.setter
  def alive(self, value):
  ```
  判断用户的状态，并设置用户状态（在用户进行登录登出操作之后）

  功能性注释：
  ```
  无
  ```

*  

  ```Python
  def dump_login_status(self, cache_path=None):
  ```
  用户状态的详细信息，用于debug时候的输出。

  功能性注释：
  ```
  无
  ```

*  

  ```Python
  def enable_puid(self, path='wxpy_puid.pkl'):
  ```
  启用puid属性。

  功能性注释：
  ```
  **可选操作:** 启用聊天对象的 :any:`puid <Chat.puid>` 属性::

    # 启用 puid 属性，并指定 puid 所需的映射数据保存/载入路径
    bot.enable_puid('wxpy_puid.pkl')

    # 指定一个好友
    my_friend = bot.friends().search('游否')[0]

    # 查看他的 puid
    print(my_friend.puid)
    # 'edfe8468'
  ..  tip::

    | :any:`puid <Chat.puid>` 是 **wxpy 特有的聊天对象/用户ID**
    | 不同于其他 ID 属性，**puid** 可始终被获取到，且具有稳定的唯一性
  :param path: puid 所需的映射数据保存/载入路径
  ```

*  

  ```Python
  def except_self(self, chats_or_dicts):
  ```
  从聊天对象集合排除自身。

  功能性注释：
  ```
  从聊天对象合集或用户字典列表中排除自身

  :param chats_or_dicts: 聊天对象合集或用户字典列表
  :return: 排除自身后的列表
  :rtype: :class:`wxpy.Chats`
  ```

*    

  ```Python
  def chats(self, update=False):
  ```
  获取所有聊天对象。

  功能性注释：
  ```
  获取所有聊天对象

  :param update: 是否更新
  :return: 聊天对象合集
  :rtype: :class:`wxpy.Chats`
  ```

*  

  ```Python
  def _retrieve_itchat_storage(self, attr):
  ```

*  

  ```Python
  @handle_response(Friend)
  def friends(self, update=False):
  ```
  获取所有好友。
  功能性注释：
  ```
  :param update: 是否更新
  :return: 聊天对象合集
  :rtype: :class:`wxpy.Chats`
  ```

*  

  ```
  @handle_response(Group)
  def groups(self, update=False, contact_only=False):
  ```
  获取所有的群。

  功能性注释：
  ```
  获取所有群聊对象

  一些不活跃的群可能无法被获取到，可通过在群内发言，或修改群名称的方式来激活

  :param update: 是否更新
  :param contact_only: 是否限于保存为联系人的群聊
  :return: 群聊合集
  :rtype: :class:`wxpy.Groups`

  # itchat 原代码有些难懂，似乎 itchat 中的 get_contact() 所获取的内容视其 update 参数而变化
  # 如果 update=False 获取所有类型的本地聊天对象
  # 反之如果 update=True，变为获取收藏的聊天室
  ```
*  
  ```Python
  @handle_response(MP)
  def mps(self, update=False):
  ```
  获取所有公众号。

  功能性注释：
  ```
  获取所有公众号

  :param update: 是否更新
  :return: 聊天对象合集
  :rtype: :class:`wxpy.Chats`
  ```

*  

  ```Python
  @handle_response(User)
  def user_details(self, user_or_users, chunk_size=50):
  ```
  获取用户信息。

  功能性注释：
  ```
  获取单个或批量获取多个用户的详细信息(地区、性别、签名等)，但不可用于群聊成员

  :param user_or_users: 单个或多个用户对象或 user_name
  :param chunk_size: 分配请求时的单批数量，目前为 50
  :return: 单个或多个用户用户的详细信息

  ```
*  

  ```Python
  def search(self, keywords=None, **attributes):
  ```
  搜索所有的聊天对象。

  功能性注释：
  ```
  在所有类型的聊天对象中进行搜索

  ..  note::

      | 搜索结果为一个 :class:`Chats (列表) <Chats>` 对象
      | 建议搭配 :any:`ensure_one()` 使用

  :param keywords: 聊天对象的名称关键词
  :param attributes: 属性键值对，键可以是 sex(性别), province(省份), city(城市) 等。例如可指定 province='广东'
  :return: 匹配的聊天对象合集
  :rtype: :class:`wxpy.Chats`
  ```

*  

  ```Python
  @handle_response()
  def add_friend(self, user, verify_content=''):
  ```
  添加好友。

  功能性注释：
  ```
  添加用户为好友

  :param user: 用户对象，或 user_name
  :param verify_content: 验证说明信息
  ```  

*  

  ```Python
  @handle_response()
  def add_mp(self, user):
  ```
  关注公众号。

  功能性注释：
  ```
  添加/关注 公众号

  :param user: 公众号对象，或 user_name
  ```

*  

  ```Python
   def accept_friend(self, user, verify_content=''):
  ```
  同意好友请求。

  功能性注释：
  ```
  接受用户为好友

  :param user: 用户对象或 user_name
  :param verify_content: 验证说明信息
  :return: 新的好友对象
  :rtype: :class:`wxpy.Friend`
  ```

*  

  ```Python
   def create_group(self, users, topic=None):
  ```
  创建一个群聊。

  功能性注释：
  ```
  创建一个新的群聊

  :param users: 用户列表 (不含自己，至少 2 位)
  :param topic: 群名称
  :return: 若建群成功，返回一个新的群聊对象
  :rtype: :class:`wxpy.Group`
  ```

*  

  ```Python
   def upload_file(self, path):
  ```
  上传文件。

  功能性注释：
  ```
  | 上传文件，并获取 media_id
  | 可用于重复发送图片、表情、视频，和文件

  :param path: 文件路径
  :return: media_id
  :rtype: str
  ```

*  

  ```Python
   def _process_message(self, msg):
  ```

  处理消息。
  功能性注释：
  ```
  处理接受到的消息
  ```

*  

  ```Python
  def register(
          self, chats=None, msg_types=None,
          except_self=True, run_async=True, enabled=True
  ):
  ```
  注册消息服务的装饰器。
  功能性注释：
  ```
  装饰器：用于注册消息配置

  :param chats: 消息所在的聊天对象：单个或列表形式的多个聊天对象或聊天类型，为空时匹配所有聊天对象
  :param msg_types: 消息的类型：单个或列表形式的多个消息类型，为空时匹配所有消息类型 (SYSTEM 类消息除外)
  :param except_self: 排除由自己发送的消息
  :param run_async: 是否异步执行所配置的函数：可提高响应速度
  :param enabled: 当前配置的默认开启状态，可事后动态开启或关闭
  ```

*  

  ```Python
   def _listen(self):
  ```
  监听方法。此处的注释中`#TODO`常用与标记一个将要时间的feture或者一个将要修复的bug。

  功能性注释：
  ```
  # TODO:在短时间内收到多条消息时，会偶尔漏收消息（Web 微信没问题）
  ```

*  

  ```Python
   def start(self):
  ```
  开始监听。

  功能性注释：
  ```
  开始消息监听和处理 (登陆后会自动开始)
  ```

*  

  ```Python
   def stop(self):
  ```
  停止监听消息。

  功能性注释：
  ```
  停止消息监听和处理 (登出后会自动停止)
  ```

*  

  ```Python
   def join(self):
  ```
  堵塞进行。

  功能性注释：
  ```
  堵塞进程，直到结束消息监听 (例如，机器人被登出时)
  ```

*  

  ```Python
   def _cleanup(self):
  ```
  对象消除时的方法（类似于析构，与__init__对应）。

  功能性注释：
  ```
  无
  ```

### 按照课题内容修改

按照课上内容，此代码编码风格符合规范，项目说明文档、使用文档、函数方法的注释齐全，
项目采用面向对象模式，本次分析的Bot类在代码编写上，变量与方法的命名都具有较好的语义，且
抽象程度合理。

但是在针对一些方法，例如获取所有好友的`friends(self, update=False)`方法，其实可以改为
`get_friends(self, update=False)`，采用类似动词-名词的方式来使得方法没有二义性，使得项目
的可读性更高。
