# ProductSliderM2
A FREE Magento 2 module for managing product sliders

- Build on top of fully responsive <a href="http://kenwheeler.github.io/slick/" target="_blank">Slick slider</a>
- Display different type of products on various locations
	-	Featured products
	-	New products
	-	Best selling products
	-	On sale products
	-	Most viewed products

# Features:
- Schedule slider to be published on specific date and time
- Various locations to choose for slider display
- Display slider on any location using xml or custom code
- Display sliders using Magento widgets
- Display products in basic grid if slider is not an option
- Choose different type off slider effects
- Choose additionals products to be displayed along basic types, <br/>
  Example (display best sellers and additional three products ) 

<br/>

Check LIVE demo:
- <a href="http://demo.jakesharpdev.com/" target="_blank">Frontend demo</a>
- <a href="http://demo.jakesharpdev.com/admin/" target="_blank">Backend demo</a>

# Installation:
<h2>Step 1</h2>
- <strong>using Composer</strong>: in magento root installation folder run into the command line:<br/>
  - <strong>composer require jakesharp/module-productslider</strong>
  
- <strong>or uploading files</strong>: download ZIP, extract files, create directory in the <strong>app/code/JakeSharp/Productslider</strong> and upload extracted files there

- <strong>or using Git</strong>: clone this repository by https or ssh <br/>
 - git clone git@github.com:JakeSharp/ProductSliderM2.git
 - git clone https://github.com/JakeSharp/ProductSliderM2.git

<h2>Step 2</h2>
- In magento root directory run following comands into the command line:
  - bin/magento module:enable JakeSharp_Productslider
  - bin/magento setup:upgrade

<h2>Step 3</h2>
- Login to Magento admin and enable extension at the JakeSharp => Settings => General => Enable

 

