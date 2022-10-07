### What did you build?
The ask itself seemed pretty easy. I decided to focus on two things not mentioned to show the type of Laravel code I've been writing lately.

Those two things are using Logging heavily and using Data classes. 

Logging is obviously a great add for debugging bugs and is often left out. Data classes (spate/laravel-data) are nice because it allows better typing throughout my code. 

You'll also notice I use PHP's type system wherever I could. 
### How long did it take?

I spent 6 hours on this project. At the start of the project I used it as a learning tool for a friend that wants to learn programming. I also spent some time digging into testing email data and using spatie/larave-data

### What challenges did you face?

The attachment handling and testing took some time. It wasn't clear if I was supposed to allow all types of files or not. I opted to allow all files but was a bit stumped on mime type detection.

If I had more context and time I would implement better file type and size validation.

### Do your test work?

Yes! And I got the CI working so you can take a look for yourself:
https://github.com/travierm/biznow-email-service/actions

### Would you release this to prod?

No! Auth is not implemented and the file validation needs to be improved. Throttling might need to be added too to prevent someone from spamming the system.
