Python语言特点
====================
Python简介
--------------------
Python是著名的“龟叔”Guido van Rossum在1989年圣诞节期间，为了打发无聊的圣诞节而编写的一个编程语言。许多大型网站就是用Python开发的，例如YouTube、Instagram，还有国内的豆瓣。很多大公司，包括Google、Yahoo等，甚至NASA（美国航空航天局）都大量地使用Python。

Python优点
---------------------
1.	简单   
Python的语法非常优雅，甚至没有像其他语言的大括号，分号等特殊符号，代表了一种极简主义的设计思想。阅读Python程序像是在读英语。

2.	易学   
Python入手非常快，学习曲线非常低，可以直接通过命令行交互环境来学习Python编程。

3.	免费/开源   
Python的所有内容都是免费开源的，这意味着你不需要花一分钱就可以免费使用Python，并且你可以自由地发布这个软件的拷贝、阅读它的源代码、对它做改动、把它的一部分用于新的自由软件中。

4.	自动内存管理   
如果你了解C语言、C++语言你就会知道内存管理给你带来很大麻烦，程序非常容易出现内存方面的漏洞。但是在Python中内存管理是自动完成的，你可以专注于程序本身。

5.	可以移植   
由于Python是开源的，它已经被移植到了大多数平台下面，例如：Windows、MacOS、Linux、Andorid、iOS等等。

6.	解释性   
大多数计算机编程语言都是编译型的，在运行之前需要将源码编译为操作系统可以执行的二进制格式(0110格式的)，这样大型项目编译过程非常消耗时间，而Python语言写的程序不需要编译成二进制代码。你可以直接从源代码运行程序。在计算机内部，Python解释器把源代码转换成称为字节码的中间形式，然后再把它翻译成计算机使用的机器语言并运行。

7.	面向对象   
Python既支持面向过程，又支持面向对象，这样编程就更加灵活。

8.	可扩展   
Python除了使用Python本身编写外，还可以混合使用像C语言、Java语言等编写。

9.	丰富的第三方库   
Python具有本身有丰富而且强大的库，而且由于Python的开源特性，第三方库也非常多，例如：在web开发、爬虫、科学计算等等

Python的缺点
--------------------
1.	运行速度慢  
和C程序相比非常慢，因为Python是解释型语言，你的代码在执行时会一行一行地翻译成CPU能理解的机器码，这个翻译过程非常耗时，所以很慢。而C程序是运行前直接编译成CPU能执行的机器码，所以非常快。

2.	不能加密  
如果要发布Python程序，实际上就是发布源代码，这一点跟C语言不同，C语言不用发布源代码，只需要把编译后的机器码发布出去。

Python适用场景
----------------------
1.	首选是网络应用，包括网站、后台服务等等；

2.	其次是许多日常需要的小工具，包括系统管理员需要的脚本任务等等；

3.	另外就是把其他语言开发的程序再包装起来，方便使用。

Python 数据类型
----------------------

Python文件对象
----------------------
Python控制结构
----------------------
1.	顺序
2.	选择(if…elis…else/switch…case)
3.	循环(for/while)

flask源代码分析
==================
Flask是python web框架，主要包含werkzeug和jinja2，前者是一个WSGI工具集，后者用来实现模板处理。
WSGI

----------------------
WSGI（Web Server Gateway Interface）是一个协议，定义了Web Server和app之间的接口。接口很简单，下面一个例子myapp.py：

```
def app(env, start_response):    
 	   start_response('200 OK', [('Content-Type', 'text/html')])  
 	   return '\<h1>Hello, web!\</h1>'  

gunicorn myapp:app 
```
gunicorn在这里作为一个WSGI web server，通过上面的命令就可以启动这个app。

Werkzeug
----------------------
Werkzeug提供了一系列工具，使WSGI编程更简单：

```
from werkzeug.wrappers import Request, Response  

def application(environ, start_response):  
    request = Request(environ)  
    text = 'Hello %s!' % request.args.get('name', 'World')  
    response = Response(text, mimetype='text/plain')  
    return response(environ, start_response)  
```   
    
上面的例子中通过Request和Response，使app代码更加pythonic。还有一些有效的工具，用来实现路由等功能，这些在flask中都有应用：
>from werkzeug.routing import Map, Rule  

jinja2
----------------------
模板处理是flask的核心功能之一，用来处理网页模板：

```
from jinja2 import Template
t = Template("{{ name }}, hello jinja2 world!")
t.render(name='Mr. Y')  #u'Mr. Y, hello jinja2 world!'
flask
from flask import Flask
app = Flask(__name__)

@app.route('/')
def hello_world():
    return 'Hello World!'

if __name__ == '__main__':
    app.run()
```
1．初始化app
----------------------
```
from flask import Flask
app = Flask(__name__)
flask.py
class Flask(object):
    def __init__(self, package_name):
        #包名
        self.package_name = package_name

        #根路径
        self.root_path = _get_package_path(self.package_name)

        #视图函数，即例子中的hello_world函数
        self.view_functions = {}

        #错误处理函数，Key是错误状态码，Value是处理函数
        self.error_handlers = {}

        #预处理函数列表
        self.before_request_funcs = []

        #后处理函数列表
        self.after_request_funcs = []

        #url到视图函数的映射
        self.url_map = Map()
```

2．路由
----------------------
```
@app.route('/')
def hello_world():
    return 'Hello World!'
flask.py
   def route(self, rule, **options):
        def decorator(f):
            self.add_url_rule(rule, f.__name__, **options)
            self.view_functions[f.__name__] = f
            return f
        return decorator
    def add_url_rule(self, rule, endpoint, **options):

        options['endpoint'] = endpoint
        options.setdefault('methods', ('GET',))
        self.url_map.add(Rule(rule, **options))
```
route是一个修饰器，功能就是完成url_map和view_functions的初始化，其中Rule是werkzeug提供的工具。

3．run
----------------------
3.1主流程
----------------------
```
if __name__ == '__main__':
    app.run()
app运行时的调用顺序是：
run
    --> werkzeug.run_simple
        --> __call__(self, environ, start_respones)
            --> wsgi_app(environ, start_response)
__call__()函数核心是wsgi_app：
    def __call__(self, environ, start_response):
        """Shortcut for :attr:`wsgi_app`"""
        return self.wsgi_app(environ, start_response)

    def wsgi_app(self, environ, start_response):
        #初始化请求
        with self.request_context(environ):
            #预处理
            rv = self.preprocess_request()
            #分发请求
            if rv is None:
                rv = self.dispatch_request()
            response = self.make_response(rv)
            #后处理
            response = self.process_response(response)
            #响应
            return response(environ, start_response)
```
3.2 初始化请求  
----------------------
请求上下文调用顺序，请求保存在\_request\_ctx\_stack中，LocalStack由werkzeug提供，并保证线程安全。

```
request_context
    --> _RequestContext(self, environ)

class _RequestContext(object):

    def __init__(self, app, environ):

        self.app = app
        self.url_adapter = app.url_map.bind_to_environ(environ)
        self.request = app.request_class(environ)
        self.session = app.open_session(self.request)
        self.g = _RequestGlobals()
        self.flashes = None

    def __enter__(self):
        _request_ctx_stack.push(self)

    def __exit__(self, exc_type, exc_value, tb):
        if tb is None or not self.app.debug:
            _request_ctx_stack.pop()

_request_ctx_stack = LocalStack()
```
3.3分发请求
----------------------
```
    def dispatch_request(self):
        try:
            endpoint, values = self.match_request()
            return self.view_functions[endpoint](**values)
        except HTTPException, e:
            handler = self.error_handlers.get(e.code)
            if handler is None:
                return e
            return handler(e)
        except Exception, e:
            handler = self.error_handlers.get(500)
            if self.debug or handler is None:
                raise
            return handler(e)
```
查询视图函数view_functions获得响应的处理函数。如果异常则返回响应的异常处理函数。



