#encoding: utf-8
class ResponsesController < ApplicationController
  # GET /responses
  # GET /responses.json
  def index
    @responses = Response.all

    respond_to do |format|
      format.html # index.html.erb
      format.json { render json: @responses }
    end
  end

  # GET /responses/1
  # GET /responses/1.json
  def show
#    @package_id=params[:package_id]
    @response = Response.find(params[:id])

    respond_to do |format|
      format.html # show.html.erb
      format.json { render json: @response }
    end
  end

  # GET /responses/new
  # GET /responses/new.json
  def new
    @response = Response.new

    respond_to do |format|
      format.html # new.html.erb
      format.json { render json: @response }
    end
  end

  # GET /responses/1/edit
  def edit
    @response = Response.find(params[:id])
  end

  # GET /responses/1/res
  def faq
    @response = Response.find(:all, :conditions => ["package_id = ?", params[:id]])
    #@package = Package.find(:all, :conditions => ["id = ?", params[:id]])
    @package = Package.find(params[:id])
    respond_to do |format|
      format.html # faq.tml.erb
      format.json { render json: @response }
    end
  end
  #
  # POST /responses
  # POST /responses.json
  def create
    @response = Response.new(params[:response])

    respond_to do |format|
      if  @response.save
        format.html { redirect_to responses_path, notice: 'Response was successfully created.' }
        format.json { render json: @response, status: :created, location: @response }
      else
        format.html { render action: "new" }
        format.json { render json: @response.errors, status: :unprocessable_entity }
      end
    end
  end

  # PUT /responses/1
  # PUT /responses/1.json
  def update
    @response = Response.find(params[:id])

    respond_to do |format|
      # if verify_recaptcha
        if @response.update_attributes(params[:response])
          format.html { redirect_to response_path, notice: 'Response was successfully updated.' }
          format.json { head :no_content }
        else
          format.html { render action: "edit" }
          format.json { render json: @response.errors, status: :unprocessable_entity }
        end
      #else
      #  flash.now[:alert] = "There was an error with the recaptcha code below. Please re-enter the code."      
      #  flash.delete :recaptcha_error 
      #end
    end
  end

  # DELETE /responses/1
  # DELETE /responses/1.json
  def destroy
    @response = Response.find(params[:id])
    @response.destroy

    respond_to do |format|
      format.html { redirect_to responses_url }
      format.json { head :no_content }
    end
  end
end
