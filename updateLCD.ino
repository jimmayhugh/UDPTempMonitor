/*
UDPTempMonitor - updateLCD.ino

Permission is hereby granted, free of charge, to any person obtaining
a copy of this software and associated documentation files (the
"Software"), to deal in the Software without restriction, including
without limitation the rights to use, copy, modify, merge, publish,
distribute, sublicense, and/or sell copies of the Software, and to
permit persons to whom the Software is furnished to do so, subject to
the following conditions:

The above copyright notice and this permission notice shall be
included in all copies or substantial portions of the Software.0
This software uses multiple libraries that are subject to additional
licenses as defined by the author of that software. It is the user's
and developer's responsibility to determine and adhere to any additional
requirements that may arise.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND,
EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF
MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND
NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE
LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION
OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION
WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.
*/

void updateLCD(void)
{
  uint8_t x, y;
  
  if(setDebug & lcdDebug)
  {
    Serial.println("Writing to LCD");
  }
  lcd.home();
  for( x= 0; x < lcdRows; x++)
  {
    delay(delayVal);
    lcd.setCursor(0, x);
    for( y = 0; y < lcdBufferSize; y++) // clear the LCD Buffer
      lcdBuffer[y] = ' ';
    if(tempSet == 'F')
    {
      packetCnt = sprintf(lcdBuffer, "%s",ds18b20[x].tempName);
      lcdBuffer[packetCnt] = ' ';
      dtostrf(((ds18b20[x].tempVal * 1.8) + 32.0) , 4, 2, tempf);
      y = strlen(tempf);
      sprintf(&lcdBuffer[sizeof(lcdBuffer) - (y+3)], "%s", tempf);
    }else{
      packetCnt = sprintf(lcdBuffer, "%s",ds18b20[x].tempName);
      lcdBuffer[packetCnt] = ' ';
      dtostrf(ds18b20[x].tempVal , 4, 2, tempf);
      y = strlen(tempf);
      sprintf(&lcdBuffer[sizeof(lcdBuffer) - (y+3)], "%s", tempf);
    }
    lcd.print(lcdBuffer);
    lcd.setCursor(18, x);
    lcd.print(degree);
    lcd.setCursor(19, x);      
    if(tempSet == 'F')
    {
      lcd.print('F');
    }else{
      lcd.print('C');
    }

    delay(delayVal);
  }
  if(setDebug & lcdDebug)
  {
    Serial.println(lcdBuffer);
    Serial.println("Finished writing to LCD");
  }
}

char *ftoa(char *a, double f, int precision)
{
 long p[] = {0,10,100,1000,10000,100000,1000000,10000000,100000000};
 
 char *ret = a;
 long heiltal = (long)f;
 itoa(heiltal, a, 10);
 while (*a != '\0') a++;
 *a++ = '.';
 long desimal = abs((long)((f - heiltal) * p[precision]));
 itoa(desimal, a, 10);
 return ret;
}

